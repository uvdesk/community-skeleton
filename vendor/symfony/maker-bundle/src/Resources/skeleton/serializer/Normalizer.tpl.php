<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

<?= ($cacheable_interface = interface_exists('Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface')) ? "use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;\n": '' ?>
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class <?= $class_name ?> implements NormalizerInterface<?= $cacheable_interface ? ', CacheableSupportsMethodInterface' : '' ?><?= "\n" ?>
{
    private $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($object, $format = null, array $context = array()): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        // Here: add, edit, or delete some data

        return $data;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof \App\Entity\BlogPost;
    }
<?php if($cacheable_interface): ?>

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
<?php endif; ?>
}
