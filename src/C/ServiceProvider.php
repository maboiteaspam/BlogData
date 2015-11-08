<?php

namespace C\BlogData;

// @todo data providers does not need the whole silex stack, they only need some interface definitions
// @todo this would help to reduce dependencies to their minimum.
use Silex\Application;
use Silex\ServiceProviderInterface;
use \C\BlogData\PO as PO;
use \C\BlogData\Eloquent as Eloquent;

/**
 * Class ServiceProvider
 * provides blog data services
 * to connect your application with.
 *
 * @package C\BlogData
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     **/
    public function register(Application $app)
    {
        // define the underlying data provider type
        // Eloquent or PO
        if (!isset($app['blogdata.provider']))
            $app['blogdata.provider'] = 'PO';

        // provides blog entry data services
        $app['blogdata.entry'] = $app->share(function () use($app) {
            $repo = null;
            if ($app['blogdata.provider']==='PO') {
                $repo = new PO\EntryRepository();
            } else if ($app['blogdata.provider']==='Eloquent') {
                $repo = new Eloquent\EntryRepository();
                $repo->setCapsule($app['capsule']);
            }
            $repo->setRepositoryName('blogdata.entry');
            return $repo;
        });

        // provides blog entry's comment data services
        $app['blogdata.comment'] = $app->share(function () use($app) {
            $repo = null;
            if ($app['blogdata.provider']==='PO') {
                $repo = new PO\CommentRepository();
            } else if ($app['blogdata.provider']==='Eloquent') {
                $repo = new Eloquent\CommentRepository();
                $repo->setCapsule($app['capsule']);
            }
            $repo->setRepositoryName('blogdata.comment');
            return $repo;
        });

        // provides blog entry and comment
        // schema services
        $app['blogdata.schema'] = $app->share(function () use($app) {
            $schema = null;
            if ($app['blogdata.provider']==='PO') {
                $schema = new PO\Schema;
            } else if ($app['blogdata.provider']==='Eloquent') {
                $schema = new Eloquent\Schema($app['capsule']);
            }
            return $schema;
        });
    }

    public function boot(Application $app)
    {
        // if capsule service provider is connected
        // register the blog schema service.
        if (isset($app['capsule.schema'])) {
            $app['capsule.schema']->register($app['blogdata.schema']);
        }
    }
}
