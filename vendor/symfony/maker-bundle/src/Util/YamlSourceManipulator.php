<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Util;

use Psr\Log\LoggerInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * A class that modifies YAML source, while keeping comments & formatting.
 *
 * This is designed to work for the most common syntaxes, but not
 * all YAML syntaxes. If content cannot be updated safely, an
 * exception is thrown.
 */
class YamlSourceManipulator
{
    const EMPTY_LINE_PLACEHOLDER_VALUE = '__EMPTY_LINE__';
    const COMMENT_PLACEHOLDER_VALUE = '__COMMENT__';

    const UNSET_KEY_FLAG = '__MAKER_VALUE_UNSET';
    const ARRAY_FORMAT_MULTILINE = 'multi';
    const ARRAY_FORMAT_INLINE = 'inline';

    const ARRAY_TYPE_SEQUENCE = 'sequence';
    const ARRAY_TYPE_HASH = 'hash';

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    private $contents;
    private $currentData;

    private $currentPosition = 0;
    private $previousPath = [];
    private $currentPath = [];
    private $depth = 0;
    private $indentationForDepths = [];
    private $arrayFormatForDepths = [];
    private $arrayTypeForDepths = [];

    public function __construct(string $contents)
    {
        $this->contents = $contents;
        $this->currentData = Yaml::parse($contents);

        if (!\is_array($this->currentData)) {
            throw new \InvalidArgumentException('Only YAML with a top-level array structure is supported');
        }
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getData(): array
    {
        return $this->currentData;
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function setData(array $newData)
    {
        $this->currentPath = [];
        $this->previousPath = [];
        $this->currentPosition = 0;
        $this->depth = -1;
        $this->indentationForDepths = [];
        $this->arrayFormatForDepths = [];
        $this->arrayTypeForDepths = [];

        $this->updateData($newData);
        $this->replaceSpecialMetadataCharacters();
        // update the data now that the special chars have been removed
        $this->currentData = Yaml::parse($this->contents);

        // Before comparing, re-index any sequences on the new data.
        // The current data will already use sequential indexes
        $newData = $this->normalizeSequences($newData);
        // remove special metadata keys that were replaced
        $newData = $this->removeMetadataKeys($newData);

        if ($newData !== $this->currentData) {
            throw new YamlManipulationFailedException(sprintf('Failed updating YAML contents: the process was successful, but something was not updated. Expected new data: %s. Actual new data: %s', var_export($newData, true), var_export($this->currentData, true)));
        }
    }

    public function createEmptyLine(): string
    {
        return self::EMPTY_LINE_PLACEHOLDER_VALUE;
    }

    public function createCommentLine(string $comment): string
    {
        return sprintf(self::COMMENT_PLACEHOLDER_VALUE.$comment);
    }

    private function updateData(array $newData)
    {
        ++$this->depth;
        if (0 === $this->depth) {
            $this->indentationForDepths[$this->depth] = 0;
            $this->arrayFormatForDepths[$this->depth] = self::ARRAY_FORMAT_MULTILINE;
        } else {
            // match the current indentation to start
            $this->indentationForDepths[$this->depth] = $this->indentationForDepths[$this->depth - 1];
            // advancing is especially important if this is an inline array:
            // get into the [] or {}
            $this->arrayFormatForDepths[$this->depth] = $this->guessNextArrayTypeAndAdvance();
        }

        $currentData = $this->getCurrentData();

        $this->arrayTypeForDepths[$this->depth] = $this->isHash($currentData) ? self::ARRAY_TYPE_HASH : self::ARRAY_TYPE_SEQUENCE;

        $this->log(sprintf(
            'Changing array type & format via updateData()',
            $this->arrayTypeForDepths[$this->depth],
            $this->arrayFormatForDepths[$this->depth]
        ));

        foreach ($currentData as $key => $currentVal) {
            // path setting is mostly duplicated at the bottom of this method
            $this->previousPath = $this->currentPath;
            if (!isset($this->previousPath[$this->depth])) {
                // if there is no previous flag at this level, mark it with a null
                $this->previousPath[$this->depth] = null;
            }
            $this->currentPath[$this->depth] = $key;

            // advance from the end of the previous value to the
            // start of the key, which may include whitespace or, for
            // example, some closing array syntax - } or ] - from the
            // previous value
            $this->advanceBeyondEndOfPreviousKey($key);

            $this->log('START key', true);

            // 1) was this key removed from the new data?
            if (!\array_key_exists($key, $newData)) {
                $this->log('Removing key');
                $this->removeKeyFromYaml($key, $currentData[$key]);

                // manually update our current data now that the key is gone
                unset($currentData[$key]);

                // because the item was removed, reset the current path
                // to the previous path, so the next iteration doesn't
                // expect the previous path to have this removed key
                $this->currentPath = $this->previousPath;

                continue;
            }

            /*
             * 2) are there new keys in the new data before this key?
             *
             * To determine this, we look at the position of the key inside the
             * current data and compare it to the position of that same key in
             * the new data. While they are not equal, we loop. Inside the loop,
             * the new key is added to the current data *before* $key. Thanks to
             * this, on each loop, the currentDataIndex will increase until it
             * matches the new data
             */
            while (($currentDataIndex = array_search($key, array_keys($currentData))) !== array_search($key, array_keys($newData))) {
                // loop until the current key is found at the same position in current & new data
                $newKey = array_keys($newData)[$currentDataIndex];
                $newVal = $newData[$newKey];
                $this->log('Adding new key: '.$newKey);

                $this->addNewKeyToYaml($newKey, $newVal);

                // refresh the current array data because we added an item
                // we can't just add the key manually, as it may have been
                // we can't just add the key manually, as it may have been
                // added in the middle
                $currentData = $this->getCurrentData(1);
            }

            // 3) Key already exists in YAML
            // advance the position to the end of this key
            $this->advanceBeyondKey($key);
            $newVal = $newData[$key];

            // if the current data is an array, we should keep
            // walking through that data, even if it didn't change,
            // so that we can advance the current position
            if (\is_array($currentData[$key]) && \is_array($newVal)) {
                $this->log('Calling updateData() on next level');
                $this->updateData($newVal);

                continue;
            }

            // 3a) value did NOT change
            if ($currentData[$key] === $newVal) {
                $this->log('value did not change');
                $this->advanceBeyondValue($newVal);

                continue;
            }

            // 3b) value DID change
            $this->log('updating value');
            $this->changeValueInYaml($newVal);
        }

        // Bonus! are there new keys in the data after this key...
        // and this is the final key?

        // Edge case: if the last item on a multi-line array has a comment,
        // we want to move to the end of the line, beyond that comment
        if (\count($currentData) < \count($newData) && $this->isCurrentArrayMultiline()) {
            $this->advanceToEndOfLine();
        }

        while (\count($currentData) < \count($newData)) {
            $newKey = array_keys($newData)[\count($currentData)];

            // manually move the paths forward
            // mostly duplicated above
            $this->previousPath = $this->currentPath;
            if (!isset($this->previousPath[$this->depth])) {
                // if there is no previous flag at this level, mark it with a null
                $this->previousPath[$this->depth] = null;
            }
            $this->currentPath[$this->depth] = $newKey;

            $newVal = $newData[$newKey];
            $this->log('Adding new key to end of array');

            $this->addNewKeyToYaml($newKey, $newVal);

            // refresh manually so the while sees it above
            $currentData = $this->getCurrentData(1);
        }

        $this->decrementDepth();
    }

    /**
     * Adds a new key to current position in the YAML.
     *
     * The position should be set *right* where this new key
     * should be inserted.
     *
     * @param mixed $key
     * @param mixed $value
     */
    private function addNewKeyToYaml($key, $value)
    {
        $extraOffset = 0;
        $firstItemInArray = false;
        if (empty($this->getCurrentData(1))) {
            // The array that we're appending is empty:

            // First, fix the "type" - it could be changing from a sequence to a hash or vice versa
            $this->arrayTypeForDepths[$this->depth] = \is_int($key) ? self::ARRAY_TYPE_SEQUENCE : self::ARRAY_TYPE_HASH;

            // we prefer multi-line, so let's convert to it!
            $this->arrayFormatForDepths[$this->depth] = self::ARRAY_FORMAT_MULTILINE;

            // if this is an inline empty array (is there any other), we need to
            // remove the empty array characters = {} or []

            // we are already 1 character beyond the starting { or [ - so, rewind before it
            --$this->currentPosition;
            // now, rewind any spaces to get back to the : after the key
            while (' ' === substr($this->contents, $this->currentPosition - 1, 1)) {
                --$this->currentPosition;
            }

            // determine an extra offset to "skip" when reconstructing the string
            $endingArrayPosition = $this->findPositionOfNextCharacter(['}', ']']);
            $extraOffset = $endingArrayPosition - $this->currentPosition;

            // increase the indentation of *this* level
            $this->manuallyIncrementIndentation();

            $firstItemInArray = true;
        } elseif ($this->isPositionAtBeginningOfArray()) {
            $firstItemInArray = true;

            // the array is not empty, but we are prepending an element
            if ($this->isCurrentArrayMultiline()) {
                // indentation will be set to low, except for root level
                if ($this->depth > 0) {
                    $this->manuallyIncrementIndentation();
                }
            } else {
                // we're at the start of an inline array
                // advance beyond any whitespace so that our new key
                // uses the same whitespace that was originally after
                // the { or [
                $this->advanceBeyondWhitespace();
            }
        }

        if (\is_int($key)) {
            if ($this->isCurrentArrayMultiline()) {
                $newYamlValue = '- '.$this->convertToYaml($value);
            } else {
                $newYamlValue = $this->convertToYaml($value);
            }
        } else {
            $newYamlValue = $this->convertToYaml([$key => $value]);
        }

        if (0 === $this->currentPosition) {
            // if we're at the beginning of the file, the situation is special:
            // no previous blank line is needed, but we DO need to add a blank
            // line after, because the remainder of the content expects the
            // current position the start at the beginning of a new line
            $newYamlValue = $newYamlValue."\n";
        } else {
            if ($this->isCurrentArrayMultiline()) {
                // because we're inside a multi-line array, put this item
                // onto the *next* line & indent it

                $newYamlValue = "\n".$this->indentMultilineYamlArray($newYamlValue);
            } else {
                if ($firstItemInArray) {
                    // avoid the starting "," if first item in array
                    // but, DO add an ending ","
                    $newYamlValue = $newYamlValue.', ';
                } else {
                    $newYamlValue = ', '.$newYamlValue;
                }
            }
        }

        $newContents = substr($this->contents, 0, $this->currentPosition)
            .$newYamlValue
            .substr($this->contents, $this->currentPosition + $extraOffset);
        // manually bump the position: we didn't really move forward
        // any in the existing string, we just added our own new content
        $this->currentPosition = $this->currentPosition + \strlen($newYamlValue);

        if (0 === $this->depth) {
            $newData = $this->currentData;
            $newData = $this->appendToArrayAtCurrentPath($key, $value, $newData);
        } else {
            // first, append to the "local" array: the little array we're currently working on
            $newLocalData = $this->getCurrentData(1);
            $newLocalData = $this->appendToArrayAtCurrentPath($key, $value, $newLocalData);
            // second, set this new array inside the full data
            $newData = $this->currentData;
            $newData = $this->setValueAtCurrentPath($newLocalData, $newData, 1);
        }

        $this->updateContents(
            $newContents,
            $newData,
            $this->currentPosition
        );
    }

    private function removeKeyFromYaml($key, $currentVal)
    {
        $endKeyPosition = $this->getEndOfKeyPosition($key);

        $endKeyPosition = $this->findEndPositionOfValue($currentVal, $endKeyPosition);

        if ($this->isCurrentArrayMultiline()) {
            $nextNewLine = $this->findNextLineBreak($endKeyPosition);
            // it's possible we're at the end of the file so there are no more \n
            if (false !== $nextNewLine) {
                $endKeyPosition = $nextNewLine;
            }
        } else {
            // find next ending character - , } or ]
            while (!\in_array($currentChar = substr($this->contents, $endKeyPosition, 1), [',', ']', '}'])) {
                ++$endKeyPosition;
            }

            // if a sequence or hash is ending, and the character before it is a space, keep that
            if ((']' === $currentChar || '}' === $currentChar) && ' ' === substr($this->contents, $endKeyPosition - 1, 1)) {
                --$endKeyPosition;
            }
        }

        $newPositionBump = 0;
        $extraContent = '';
        if (1 === \count($this->getCurrentData(1))) {
            // the key being removed is the *only* key
            // we need to close the new, empty array
            $extraContent = ' []';
            // when processing arrays normally, the position is set
            // after the opening character. Move this here manually
            $newPositionBump = 2;

            // if it *was* multiline, the indentation is now lost
            if ($this->isCurrentArrayMultiline()) {
                $this->indentationForDepths[$this->depth] = $this->indentationForDepths[$this->depth - 1];
            }
            // it is now definitely a sequence
            $this->arrayTypeForDepths[$this->depth] = self::ARRAY_TYPE_SEQUENCE;
            // it is now inline
            $this->arrayFormatForDepths[$this->depth] = self::ARRAY_FORMAT_INLINE;
        }

        $newContents = substr($this->contents, 0, $this->currentPosition)
            .$extraContent
            .substr($this->contents, $endKeyPosition);

        $newData = $this->currentData;
        $newData = $this->removeKeyAtCurrentPath($newData);

        // instead of passing the new +2 position below, we do it here
        // manually. This is because this it's not a real position move,
        // we manually (above) added some new chars that didn't exist before
        $this->currentPosition = $this->currentPosition + $newPositionBump;

        $this->updateContents(
            $newContents,
            $newData,
            // position is unchanged: just some content was removed
            $this->currentPosition
        );
    }

    /**
     * Replaces the value at the current position with this value.
     *
     * The position should be set right at the start of this value
     * (i.e. after its key).
     *
     * @param mixed $value The new value to set into YAML
     */
    private function changeValueInYaml($value)
    {
        $originalVal = $this->getCurrentData();

        $endValuePosition = $this->findEndPositionOfValue($originalVal);

        $newYamlValue = $this->convertToYaml($value);
        if (!\is_array($originalVal) && \is_array($value)) {
            // we're converting from a scalar to a (multiline) array
            // this means we need to break onto the next line

            // increase the indentation
            $this->manuallyIncrementIndentation();
            $newYamlValue = "\n".$this->indentMultilineYamlArray($newYamlValue);
        } else {
            // empty space between key & value
            $newYamlValue = ' '.$newYamlValue;
        }
        $newContents = substr($this->contents, 0, $this->currentPosition)
            .$newYamlValue
            .substr($this->contents, $endValuePosition);

        $newPosition = $this->currentPosition + \strlen($newYamlValue);

        $newData = $this->currentData;
        $newData = $this->setValueAtCurrentPath($value, $newData);

        $this->updateContents(
            $newContents,
            $newData,
            $newPosition
        );
    }

    private function advanceBeyondKey($key)
    {
        $this->log(sprintf('Advancing position beyond key "%s"', $key));
        $this->advanceCurrentPosition($this->getEndOfKeyPosition($key));
    }

    private function advanceBeyondEndOfPreviousKey($key)
    {
        $this->log('Advancing position beyond PREV key');
        $this->advanceCurrentPosition($this->getEndOfPreviousKeyPosition($key));
    }

    private function advanceBeyondValue($value)
    {
        if (\is_array($value)) {
            throw new \LogicException('Do not pass an array to this method');
        }

        $this->log(sprintf('Advancing position beyond value "%s"', $value));
        $this->advanceCurrentPosition($this->findEndPositionOfValue($value));
    }

    private function getEndOfKeyPosition($key)
    {
        preg_match($this->getKeyRegex($key), $this->contents, $matches, PREG_OFFSET_CAPTURE, $this->currentPosition);

        if (empty($matches)) {
            // for integers, the key may not be explicitly printed
            if (\is_int($key)) {
                return $this->currentPosition;
            }

            throw new YamlManipulationFailedException(sprintf('Cannot find the key "%s"', $key));
        }

        return $matches[0][1] + \strlen($matches[0][0]);
    }

    /**
     * Finds the end position of the key that comes *before* this key.
     */
    private function getEndOfPreviousKeyPosition($key): int
    {
        preg_match($this->getKeyRegex($key), $this->contents, $matches, PREG_OFFSET_CAPTURE, $this->currentPosition);

        if (empty($matches)) {
            // for integers, the key may not be explicitly printed
            if (\is_int($key)) {
                return $this->currentPosition;
            }

            throw new YamlManipulationFailedException(sprintf('Cannot find the key "%s"', $key));
        }

        $startOfKey = $matches[0][1];

        // if we're at the start of the file, we're done!
        if (0 === $startOfKey) {
            return 0;
        }

        /*
         * Now, walk backwards: so that the position is before any
         * whitespace, commas or line breaks. Basically, we want to go
         * back to the first character *after* the previous key started.
         */
        // walk back any spaces
        while (' ' === substr($this->contents, $startOfKey - 1, 1)) {
            --$startOfKey;
        }

        // find either a line break or a , that is the end of the previous key
        while (\in_array(($char = substr($this->contents, $startOfKey - 1, 1)), [',', "\n"])) {
            --$startOfKey;
        }

        // look for \r\n
        if ("\r" === substr($this->contents, $startOfKey - 1, 1)) {
            --$startOfKey;
        }

        // if we're at the start of a line, if the prev line is a comment, move before it
        if ($this->isCharLineBreak(substr($this->contents, $startOfKey, 1))) {
            // move one (or two) forward so the code below finds the *previous* line
            ++$startOfKey;

            if ($this->isCharLineBreak(substr($this->contents, $startOfKey, 1))) {
                ++$startOfKey;
            }

            /*
             * In a multi-line array, the previous line(s) could be 100% comments.
             * In that situation, we want to rewind to *before* the comments, so
             * that those comments are attached to the current key and move with it.
             */
            while ($this->isPreviousLineComment($startOfKey)) {
                --$startOfKey;
                // if this is a \n\r, we need to go back an extra char
                if ("\r" === substr($this->contents, $startOfKey - 1, 1)) {
                    --$startOfKey;
                }

                while (!$this->isCharLineBreak(substr($this->contents, $startOfKey - 1, 1))) {
                    --$startOfKey;

                    // we've reached the start of the file!
                    if (0 === $startOfKey) {
                        break;
                    }
                }
            }

            if (0 !== $startOfKey) {
                // move backwards one onto the previous line
                --$startOfKey;
            }

            // look for \n\r situation
            if ("\r" === substr($this->contents, $startOfKey - 1, 1)) {
                --$startOfKey;
            }
        }

        return $startOfKey;
    }

    private function getKeyRegex($key)
    {
        return sprintf('#%s( )*:#', preg_quote($key));
    }

    private function updateContents(string $newContents, array $newData, int $newPosition)
    {
        $this->log('updateContents()');

        // validate the data
        try {
            $parsedContentsData = Yaml::parse($newContents);

            // normalize indexes on sequences to avoid comparison problems
            $parsedContentsData = $this->normalizeSequences($parsedContentsData);
            $newData = $this->normalizeSequences($newData);
            if ($parsedContentsData !== $newData) {
                //var_dump(Yaml::parse($newContents), $newData, $newContents);die;
                throw new YamlManipulationFailedException(sprintf('Content was updated, but updated content does not match expected data. Original source: "%s", updated source: "%s", updated data: %s', $this->contents, $newContents, var_export($newData, true)));
            }
        } catch (ParseException $e) {
            throw new YamlManipulationFailedException(sprintf('Could not update YAML: a parse error occurred in the new content: "%s"', $newContents));
        }

        // must be called before changing the contents
        $this->advanceCurrentPosition($newPosition);
        $this->contents = $newContents;
        $this->currentData = $newData;
    }

    private function convertToYaml($data)
    {
        $newDataString = Yaml::dump($data, 4);
        // new line is appended: remove it
        $newDataString = rtrim($newDataString, "\n");

        return $newDataString;
    }

    /**
     * Adds a new item (with the given key) to the $data array at the correct position.
     *
     * The $data should be the simple array that should be updated and that
     * the current path is pointing to. The current path is used
     * to determine *where* in the array to put the new item (so that it's
     * placed in the middle when necessary).
     */
    private function appendToArrayAtCurrentPath($key, $value, array $data): array
    {
        if ($this->isPositionAtBeginningOfArray()) {
            // this should be prepended
            return [$key => $value] + $data;
        }

        $offset = array_search($this->previousPath[$this->depth], array_keys($data));

        // if the target is currently the end of the array, just append
        if ($offset === (\count($data) - 1)) {
            $data[$key] = $value;

            return $data;
        }

        return array_merge(
            \array_slice($data, 0, $offset + 1),
            [$key => $value],
            \array_slice($data, $offset + 1, null)
        );
    }

    private function setValueAtCurrentPath($value, array $data, int $limitLevels = 0)
    {
        // create a reference
        $dataRef = &$data;

        // start depth at $limitLevels (instead of 0) to properly detect when to set the key
        $depth = $limitLevels;
        $path = \array_slice($this->currentPath, 0, \count($this->currentPath) - $limitLevels);
        foreach ($path as $key) {
            if (!\array_key_exists($key, $dataRef)) {
                throw new \LogicException(sprintf('Could not find the key "%s" from the current path "%s" in data "%s"', $key, implode(', ', $path), var_export($data, true)));
            }

            if ($depth === $this->depth) {
                // we're at the correct depth!
                if (self::UNSET_KEY_FLAG === $value) {
                    unset($dataRef[$key]);

                    // if this is a sequence, reindex the keys
                    if ($this->isCurrentArraySequence()) {
                        $dataRef = array_values($dataRef);
                    }
                } else {
                    $dataRef[$key] = $value;
                }

                return $data;
            }

            // get a deeper reference
            $dataRef = &$dataRef[$key];

            ++$depth;
        }

        throw new \LogicException('The value was not updated.');
    }

    private function removeKeyAtCurrentPath(array $data): array
    {
        return $this->setValueAtCurrentPath(self::UNSET_KEY_FLAG, $data);
    }

    /**
     * Returns the value in the current data that is currently
     * being looked at.
     *
     * This could fail if the currentPath is for new data.
     *
     * @param int $limitLevels If set to 1, the data 1 level up will be returned
     *
     * @return mixed
     */
    private function getCurrentData(int $limitLevels = 0)
    {
        $data = $this->currentData;
        $path = \array_slice($this->currentPath, 0, \count($this->currentPath) - $limitLevels);
        foreach ($path as $key) {
            if (!\array_key_exists($key, $data)) {
                throw new \LogicException(sprintf('Could not find the key "%s" from the current path "%s" in data "%s"', $key, implode(', ', $path), var_export($this->currentData, true)));
            }

            $data = $data[$key];
        }

        return $data;
    }

    private function findEndPositionOfValue($value, $offset = null)
    {
        if (\is_array($value)) {
            $currentPosition = $this->currentPosition;
            $this->log('Walking across array to find end position of array');
            $this->updateData($value);
            $endKeyPosition = $this->currentPosition;
            $this->currentPosition = $currentPosition;

            return $endKeyPosition;
        }

        if (is_scalar($value) || null === $value) {
            if (\is_bool($value)) {
                // (?i) & (?-i) opens/closes case insensitive match
                $pattern = sprintf('(?i)%s(?-i)', $value ? 'true' : 'false');
            } elseif (null === $value) {
                $pattern = '(~|NULL|null|\n)';
            } else {
                $pattern = sprintf('\'?"?%s\'?"?', preg_quote($value, '#'));
            }

            $offset = null === $offset ? $this->currentPosition : $offset;

            preg_match(sprintf('#%s#', $pattern), $this->contents, $matches, PREG_OFFSET_CAPTURE, $offset);
            if (empty($matches)) {
                throw new YamlManipulationFailedException(sprintf('Cannot find the original value "%s"', $value));
            }

            return $matches[0][1] + \strlen($matches[0][0]);
        }

        // there are other possible values, but we don't support them
        throw new YamlManipulationFailedException(sprintf('Unsupported Yaml value of type "%s"', \gettype($value)));
    }

    private function advanceCurrentPosition(int $newPosition)
    {
        $originalPosition = $this->currentPosition;
        $this->currentPosition = $newPosition;

        // if we're not changing, or moving backwards, don't count indent
        // changes
        if ($newPosition <= $originalPosition) {
            return;
        }

        /*
         * A bit of a workaround. At times, this function will be called when the
         * position is at the beginning of the line: so, one character *after*
         * a line break. In that case, if there are a group of spaces at the
         * beginning of this first line, they *should* be used to calculate the new
         * indentation. To force this, if we detect this situation, we move one
         * character backwards, so that the first line is considered a valid line
         * to look for indentation.
         */
        if ($this->isCharLineBreak(substr($this->contents, $originalPosition - 1, 1))) {
            --$originalPosition;
        }

        // look for empty lines and track the current indentation
        $advancedContent = substr($this->contents, $originalPosition, $newPosition - $originalPosition);
        $previousIndentation = $this->indentationForDepths[$this->depth];
        $newIndentation = $previousIndentation;
        if (false !== strpos($advancedContent, "\n")) {
            $lines = explode("\n", $advancedContent);
            if (!empty($lines)) {
                $lastLine = $lines[\count($lines) - 1];
                $lastLine = trim($lastLine, "\r");
                $indentation = 0;
                while (' ' === substr($lastLine, $indentation, 1)) {
                    ++$indentation;
                }

                $newIndentation = $indentation;
            }
        }

        $this->log(sprintf('Calculating new indentation: changing from %d to %d', $this->indentationForDepths[$this->depth], $newIndentation), true);
        $this->indentationForDepths[$this->depth] = $newIndentation;
    }

    private function decrementDepth()
    {
        unset($this->indentationForDepths[$this->depth]);
        unset($this->arrayFormatForDepths[$this->depth]);
        unset($this->arrayTypeForDepths[$this->depth]);
        unset($this->currentPath[$this->depth]);
        unset($this->previousPath[$this->depth]);
        --$this->depth;
    }

    private function getCurrentIndentation(): string
    {
        return str_repeat(' ', $this->indentationForDepths[$this->depth]);
    }

    private function log(string $message, $includeContent = false)
    {
        if (null === $this->logger) {
            return;
        }

        $context = [
            'key' => isset($this->currentPath[$this->depth]) ? $this->currentPath[$this->depth] : 'n/a',
            'depth' => $this->depth,
            'position' => $this->currentPosition,
            'indentation' => $this->indentationForDepths[$this->depth],
            'type' => $this->arrayTypeForDepths[$this->depth],
            'format' => $this->arrayFormatForDepths[$this->depth],
        ];

        if ($includeContent) {
            $context['content'] = sprintf(
                '>%s<',
                str_replace(["\r\n", "\n"], ['\r\n', '\n'], substr($this->contents, $this->currentPosition, 50))
            );
        }

        $this->logger->debug($message, $context);
    }

    private function isCurrentArrayMultiline(): bool
    {
        return self::ARRAY_FORMAT_MULTILINE === $this->arrayFormatForDepths[$this->depth];
    }

    private function isCurrentArraySequence(): bool
    {
        return self::ARRAY_TYPE_SEQUENCE === $this->arrayTypeForDepths[$this->depth];
    }

    /**
     * Attempts to guess if the array at the current position
     * is a multi-line array or an inline array.
     */
    private function guessNextArrayTypeAndAdvance(): string
    {
        while (true) {
            if ($this->isEOF()) {
                throw new \LogicException('Could not determine array type');
            }

            // get the next char & advance immediately
            $nextCharacter = substr($this->contents, $this->currentPosition, 1);
            // advance, but without advanceCurrentPosition()
            // because we are either moving along one line until [ {
            // or we are finding a line break and stopping: indentation
            // should not be calculated
            ++$this->currentPosition;

            if ($this->isCharLineBreak($nextCharacter)) {
                return self::ARRAY_FORMAT_MULTILINE;
            }

            if ('[' === $nextCharacter || '{' === $nextCharacter) {
                return self::ARRAY_FORMAT_INLINE;
            }
        }
    }

    /**
     * Advance until you find *one* of the characters in $chars.
     *
     * @param array $chars
     */
    private function findPositionOfNextCharacter(array $chars)
    {
        $currentPosition = $this->currentPosition;
        while (true) {
            if ($this->isEOF($currentPosition)) {
                throw new \LogicException(sprintf('Could not find any characters: %s', implode(', ', $chars)));
            }

            // get the next char & advance immediately
            $nextCharacter = substr($this->contents, $currentPosition, 1);
            ++$currentPosition;

            if (\in_array($nextCharacter, $chars)) {
                return $currentPosition;
            }
        }
    }

    private function advanceBeyondWhitespace()
    {
        while (' ' === substr($this->contents, $this->currentPosition, 1)) {
            if ($this->isEOF()) {
                return;
            }

            ++$this->currentPosition;
        }
    }

    private function advanceToEndOfLine()
    {
        while (!$this->isCharLineBreak(substr($this->contents, $this->currentPosition, 1))) {
            if ($this->isEOF()) {
                // found the end of the file!
                return;
            }

            $this->advanceCurrentPosition($this->currentPosition + 1);
        }
    }

    /**
     * Duplicated from Symfony's Inline::isHash().
     *
     * Returns true if the value must be rendered as a hash,
     * which includes an indexed array, if the indexes are
     * not sequential.
     */
    private function isHash($value): bool
    {
        if ($value instanceof \stdClass || $value instanceof \ArrayObject) {
            return true;
        }
        $expectedKey = 0;
        foreach ($value as $key => $val) {
            if ($key !== $expectedKey++) {
                return true;
            }
        }

        return false;
    }

    private function normalizeSequences(array $data)
    {
        // https://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential/4254008#4254008
        $hasStringKeys = function (array $array) {
            return \count(array_filter(array_keys($array), 'is_string')) > 0;
        };

        foreach ($data as $key => $val) {
            if (!\is_array($val)) {
                continue;
            }

            if (!$hasStringKeys($val)) {
                // avoid indexed arrays with non-sequential keys
                // e.g. if a key was removed. This causes comparison issues
                $val = array_values($val);
                $data[$key] = $val;
            }

            $data[$key] = $this->normalizeSequences($val);
        }

        return $data;
    }

    private function removeMetadataKeys(array $data)
    {
        foreach ($data as $key => $val) {
            if (\is_array($val)) {
                $data[$key] = $this->removeMetadataKeys($val);

                continue;
            }

            if (self::EMPTY_LINE_PLACEHOLDER_VALUE === $val) {
                unset($data[$key]);
            }

            if (0 === strpos($val, self::COMMENT_PLACEHOLDER_VALUE)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    private function replaceSpecialMetadataCharacters()
    {
        while (preg_match('#\n.*'.self::EMPTY_LINE_PLACEHOLDER_VALUE.'.*\n#', $this->contents, $matches)) {
            $this->contents = str_replace($matches[0], "\n\n", $this->contents);
        }

        while (preg_match('#\n(\s*).*\''.self::COMMENT_PLACEHOLDER_VALUE.'(.*)\'#', $this->contents, $matches)) {
            $fullMatch = $matches[0];
            $indentation = $matches[1];
            $comment = $matches[2];

            $this->contents = str_replace(
                $fullMatch,
                sprintf("\n%s#%s", $indentation, $comment),
                $this->contents
            );
        }
    }

    /**
     * Try to guess a preferred indentation level.
     */
    private function getPreferredIndentationSize(): int
    {
        return isset($this->indentationForDepths[1]) && $this->indentationForDepths[1] > 0 ? $this->indentationForDepths[1] : 4;
    }

    /**
     * For the array currently being processed, are we currently
     * handling the first key inside of it?
     */
    private function isPositionAtBeginningOfArray(): bool
    {
        return null === $this->previousPath[$this->depth];
    }

    private function manuallyIncrementIndentation()
    {
        $this->indentationForDepths[$this->depth] = $this->indentationForDepths[$this->depth] + $this->getPreferredIndentationSize();
    }

    private function isEOF(int $position = null)
    {
        $position = null === $position ? $this->currentPosition : $position;

        return $position === \strlen($this->contents);
    }

    private function isPreviousLineComment(int $position): bool
    {
        $line = $this->getPreviousLine($position);

        if (null === $line) {
            return false;
        }

        // adopted from Parser::isCurrentLineComment() from symfony/yaml
        $ltrimmedLine = ltrim($line, ' ');

        return '' !== $ltrimmedLine && '#' === $ltrimmedLine[0];
    }

    private function getPreviousLine(int $position)
    {
        //var_dump(substr($this->contents, $position, 10), $this->contents);die;
        // find the previous \n by finding the last one in the content up to the position
        $endPos = strrpos(substr($this->contents, 0, $position), "\n");
        if (false === $endPos) {
            // there is no previous line
            return null;
        }

        $startPos = strrpos(substr($this->contents, 0, $endPos), "\n");
        if (false === $startPos) {
            // we're at the beginning of the file
            $startPos = 0;
        } else {
            // move 1 past the line break
            ++$startPos;
        }

        $previousLine = substr($this->contents, $startPos, $endPos - $startPos);

        return trim($previousLine, "\r");
    }

    private function findNextLineBreak(int $position)
    {
        $nextNPos = strpos($this->contents, "\n", $position);
        $nextRPos = strpos($this->contents, "\r", $position);

        if (false === $nextNPos) {
            return false;
        }

        if (false === $nextRPos) {
            return $nextNPos;
        }

        // find the first possible line break character
        $nextLinePos = min($nextNPos, $nextRPos);

        // check for a \r\n situation
        if (($nextLinePos + 1) === $nextNPos) {
            ++$nextLinePos;
        }

        return $nextLinePos;
    }

    private function isCharLineBreak(string $char): bool
    {
        return "\n" === $char || "\r" === $char;
    }

    /**
     * Takes an unindented multi-line YAML string and indents it so
     * it can be inserted into the current position.
     *
     * Usually an empty line needs to be prepended to this result before
     * adding to the content.
     */
    private function indentMultilineYamlArray(string $yaml): string
    {
        // But, if the *value* is an array, then ITS children will
        // also need to be indented artificially by the same amount
        $yaml = str_replace("\n", "\n".$this->getCurrentIndentation(), $yaml);

        // now indent this level
        return $this->getCurrentIndentation().$yaml;
    }
}
