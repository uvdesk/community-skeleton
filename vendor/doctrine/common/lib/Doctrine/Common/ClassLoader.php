<?php
namespace Doctrine\Common;

use function trigger_error;
use const E_USER_DEPRECATED;

@trigger_error(ClassLoader::class . ' is deprecated.', E_USER_DEPRECATED);

/**
 * A <tt>ClassLoader</tt> is an autoloader for class files that can be
 * installed on the SPL autoload stack. It is a class loader that either loads only classes
 * of a specific namespace or all namespaces and it is suitable for working together
 * with other autoloaders in the SPL autoload stack.
 *
 * If no include path is configured through the constructor or {@link setIncludePath}, a ClassLoader
 * relies on the PHP <code>include_path</code>.
 *
 * @author Roman Borschel <roman@code-factory.org>
 * @since 2.0
 *
 * @deprecated The ClassLoader is deprecated and will be removed in version 3.0 of doctrine/common.
 */
class ClassLoader
{
    /**
     * PHP file extension.
     *
     * @var string
     */
    protected $fileExtension = '.php';

    /**
     * Current namespace.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * Current include path.
     *
     * @var string|null
     */
    protected $includePath;

    /**
     * PHP namespace separator.
     *
     * @var string
     */
    protected $namespaceSeparator = '\\';

    /**
     * Creates a new <tt>ClassLoader</tt> that loads classes of the
     * specified namespace from the specified include path.
     *
     * If no include path is given, the ClassLoader relies on the PHP include_path.
     * If neither a namespace nor an include path is given, the ClassLoader will
     * be responsible for loading all classes, thereby relying on the PHP include_path.
     *
     * @param string|null $ns          The namespace of the classes to load.
     * @param string|null $includePath The base include path to use.
     */
    public function __construct($ns = null, $includePath = null)
    {
        $this->namespace   = $ns;
        $this->includePath = $includePath;
    }

    /**
     * Sets the namespace separator used by classes in the namespace of this ClassLoader.
     *
     * @param string $sep The separator to use.
     *
     * @return void
     */
    public function setNamespaceSeparator($sep)
    {
        $this->namespaceSeparator = $sep;
    }

    /**
     * Gets the namespace separator used by classes in the namespace of this ClassLoader.
     *
     * @return string
     */
    public function getNamespaceSeparator()
    {
        return $this->namespaceSeparator;
    }

    /**
     * Sets the base include path for all class files in the namespace of this ClassLoader.
     *
     * @param string|null $includePath
     *
     * @return void
     */
    public function setIncludePath($includePath)
    {
        $this->includePath = $includePath;
    }

    /**
     * Gets the base include path for all class files in the namespace of this ClassLoader.
     *
     * @return string|null
     */
    public function getIncludePath()
    {
        return $this->includePath;
    }

    /**
     * Sets the file extension of class files in the namespace of this ClassLoader.
     *
     * @param string $fileExtension
     *
     * @return void
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;
    }

    /**
     * Gets the file extension of class files in the namespace of this ClassLoader.
     *
     * @return string
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * Registers this ClassLoader on the SPL autoload stack.
     *
     * @return void
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * Removes this ClassLoader from the SPL autoload stack.
     *
     * @return void
     */
    public function unregister()
    {
        spl_autoload_unregister([$this, 'loadClass']);
    }

    /**
     * Loads the given class or interface.
     *
     * @param string $className The name of the class to load.
     *
     * @return boolean TRUE if the class has been successfully loaded, FALSE otherwise.
     */
    public function loadClass($className)
    {
        if (self::typeExists($className)) {
            return true;
        }

        if ( ! $this->canLoadClass($className)) {
            return false;
        }

        require($this->includePath !== null ? $this->includePath . DIRECTORY_SEPARATOR : '')
               . str_replace($this->namespaceSeparator, DIRECTORY_SEPARATOR, $className)
               . $this->fileExtension;

        return self::typeExists($className);
    }

    /**
     * Asks this ClassLoader whether it can potentially load the class (file) with
     * the given name.
     *
     * @param string $className The fully-qualified name of the class.
     *
     * @return boolean TRUE if this ClassLoader can load the class, FALSE otherwise.
     */
    public function canLoadClass($className)
    {
        if ($this->namespace !== null && strpos($className, $this->namespace . $this->namespaceSeparator) !== 0) {
            return false;
        }

        $file = str_replace($this->namespaceSeparator, DIRECTORY_SEPARATOR, $className) . $this->fileExtension;

        if ($this->includePath !== null) {
            return is_file($this->includePath . DIRECTORY_SEPARATOR . $file);
        }

        return (false !== stream_resolve_include_path($file));
    }

    /**
     * Checks whether a class with a given name exists. A class "exists" if it is either
     * already defined in the current request or if there is an autoloader on the SPL
     * autoload stack that is a) responsible for the class in question and b) is able to
     * load a class file in which the class definition resides.
     *
     * If the class is not already defined, each autoloader in the SPL autoload stack
     * is asked whether it is able to tell if the class exists. If the autoloader is
     * a <tt>ClassLoader</tt>, {@link canLoadClass} is used, otherwise the autoload
     * function of the autoloader is invoked and expected to return a value that
     * evaluates to TRUE if the class (file) exists. As soon as one autoloader reports
     * that the class exists, TRUE is returned.
     *
     * Note that, depending on what kinds of autoloaders are installed on the SPL
     * autoload stack, the class (file) might already be loaded as a result of checking
     * for its existence. This is not the case with a <tt>ClassLoader</tt>, who separates
     * these responsibilities.
     *
     * @param string $className The fully-qualified name of the class.
     *
     * @return boolean TRUE if the class exists as per the definition given above, FALSE otherwise.
     */
    public static function classExists($className)
    {
        return self::typeExists($className, true);
    }

    /**
     * Gets the <tt>ClassLoader</tt> from the SPL autoload stack that is responsible
     * for (and is able to load) the class with the given name.
     *
     * @param string $className The name of the class.
     *
     * @return ClassLoader|null The <tt>ClassLoader</tt> for the class or NULL if no such <tt>ClassLoader</tt> exists.
     */
    public static function getClassLoader($className)
    {
        foreach (spl_autoload_functions() as $loader) {
            if (is_array($loader)
               && ($classLoader = reset($loader))
               && $classLoader instanceof ClassLoader
               && $classLoader->canLoadClass($className)
            ) {
                return $classLoader;
            }
        }

        return null;
    }

    /**
     * Checks whether a given type exists
     *
     * @param string $type
     * @param bool   $autoload
     *
     * @return bool
     */
    private static function typeExists($type, $autoload = false)
    {
        return class_exists($type, $autoload)
            || interface_exists($type, $autoload)
            || trait_exists($type, $autoload);
    }
}
