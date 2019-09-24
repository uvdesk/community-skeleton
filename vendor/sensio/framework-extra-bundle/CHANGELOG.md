CHANGELOG
=========

5.2
---

 * Deprecated routing annotations as this is included in symfony/framework-bundle.
   Disable the feature with

   ```
   sensio_framework_extra:
       router:
           annotations: false
   ```

   Also replace the annotations `Sensio\Bundle\FrameworkExtraBundle\Configuration\Route`
   and `Sensio\Bundle\FrameworkExtraBundle\Configuration\Method` with `Symfony\Component\Routing\Annotation\Route`

5.1
---

 * Added autoconfigure for `ParamConverterInterface` (#516).

 * Renamed service ids back to traditional service ids instead
   of class names (#530).

5.0
---

 * Changed the `@Security` annotation to use arguments from argument
   resolvers as expression variables.

 * The `@IsGranted` annotation now also supports using arguments from the
   argument resolvers as the subject.

4.0
---

 * added @IsGranted() annotation
 * allowed to disable some converters
 * allowed to customize the @security message and status code
 * [BC BREAK] changed template name generation from camelCase to under_score for both files and directories
 * removed support for bundle inheritance
 * a RuntimeException is now thrown when a reserved variable is used in a security expression
 * added cache-control max-stale support
 * renamed setETag to setEtag for consistency with Symfony core (use Etag in @Cache now instead of ETag)
 * added must-revalidate support for @Cache annotation
 * Response cache headers set in controllers now take precedence over the ones defined with the @Cache annotation
 * removed HHVM support
 * moved most services as private
 * renamed services to use their FQCN
 * allowed using multiple @Security annotations (class and method)
 * removed support for the Templating component (only plain Twig is supported)
 * removed unneeded phpdocs, converted protected to private properties
 * bumped Symfony minimum version to 3.0
 * bumped PHP minimum version to 5.5.9
 * removed class parameters in container definitions
 * [BC break] DateTimeParamConverter strictly validates the input date when using with 'format' option

3.0
---

 * fixed the Doctrine param converter that sent 500 when an entity was not found under some circumstances
 * ParamConverterInterface now uses ParamConverter as a type hint instead of ConfigurationInterface
 * added support for @Security
 * added support for HTTP validation cache in @Cache (ETag and LastModified)

2.2
---

 * added the possibility to configure the repository method to use for the
   Doctrine converter via the repository_method option.
 * [BC break] When defining multiple @Cache, @Method or @Template annotations on
   a controller class or method, the latter now overrules the former

2.1
---

 * added the possibility to configure the id name for the Doctrine converter via the id option
 * [BC break] The ParamConverterInterface::apply() method now must return a
   Boolean value indicating if a conversion was done.
