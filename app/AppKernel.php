<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
            new Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle(),
            new Liip\ThemeBundle\LiipThemeBundle(),
            new Lunetics\LocaleBundle\LuneticsLocaleBundle(),

            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(), // needed for SonataFormatterBundle
            new Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle(), // needed for SonataTranslationBundle in order to tranlsate Doctrine ORM Models


            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),

            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),

            new SunCat\MobileDetectBundle\MobileDetectBundle(),

            //  To use advanced menu options, you need the burgov/key-value-form-bundle in your project.
            new Burgov\Bundle\KeyValueFormBundle\BurgovKeyValueFormBundle(),

            // for better translated labels
            new JMS\TranslationBundle\JMSTranslationBundle(),
//            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
//            new JMS\AopBundle\JMSAopBundle(),
	
	        new Liuggio\ExcelBundle\LiuggioExcelBundle(),
            new Ornicar\GravatarBundle\OrnicarGravatarBundle(),

            // for use with Sylius Resource Component
            new winzou\Bundle\StateMachineBundle\winzouStateMachineBundle(),

            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\NotificationBundle\SonataNotificationBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\DoctrinePHPCRAdminBundle\SonataDoctrinePHPCRAdminBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\SeoBundle\SonataSeoBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),

//            new Sonata\ClassificationBundle\SonataClassificationBundle(),

            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\TranslationBundle\SonataTranslationBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),

            // you can select which bundle SonataUserBundle extends
            // Most of the cases, you'll want to extend FOSUserBundle though ;)
            // extend the ``FOSUserBundle``
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),

            // CMF Bundles
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Symfony\Cmf\Bundle\CoreBundle\CmfCoreBundle(),
            new Symfony\Cmf\Bundle\MenuBundle\CmfMenuBundle(),
            new Symfony\Cmf\Bundle\BlockBundle\CmfBlockBundle(),
            new Symfony\Cmf\Bundle\RoutingAutoBundle\CmfRoutingAutoBundle(),
            new Symfony\Cmf\Bundle\MediaBundle\CmfMediaBundle(),

            new Symfony\Cmf\Bundle\TreeBrowserBundle\CmfTreeBrowserBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(), // needed for use with CmfTreeBrowserBundle
	
	        new Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle(),
	        new Gesdinet\JWTRefreshTokenBundle\GesdinetJWTRefreshTokenBundle(),

//            new Gfreeau\Bundle\GetJWTBundle\GfreeauGetJWTBundle(),
	        new Nelmio\CorsBundle\NelmioCorsBundle(),
	        
            new Symfony\Cmf\Bundle\SeoBundle\CmfSeoBundle(),
            new Symfony\Cmf\Bundle\ResourceBundle\CmfResourceBundle(),
            new Symfony\Cmf\Bundle\ResourceRestBundle\CmfResourceRestBundle(),
//            new Symfony\Cmf\Bundle\ContentBundle\CmfContentBundle(),
//            new Symfony\Cmf\Bundle\SonataAdminIntegrationBundle\CmfSonataAdminIntegrationBundle(),


//            new Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
//            new Sylius\Bundle\CurrencyBundle\SyliusCurrencyBundle(),

            new AppBundle\AppBundle(),
//            for Sonata
//            new Application\Sonata\ClassificationBundle\ApplicationSonataClassificationBundle(),
//            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
//            new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),

            new Bean\Bundle\CoreBundle\BeanCoreBundle(),
            new Bean\Bundle\LocationBundle\BeanLocationBundle(),
//            new Application\Bean\LocationBundle\ApplicationBeanLocationBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__) . '/var/cache/' . $this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__) . '/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
