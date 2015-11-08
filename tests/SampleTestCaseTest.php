<?php
namespace C\BlogData\Tests;

use C\BlogData\Entity\Entry;
use C\BlogData\EntryRepositoryInterface;
use C\BlogData\ServiceProvider as BlogData;
use C\Eloquent\ServiceProvider as Eloquent;
use Silex\Application;
use Silex\WebTestCase;

class SampleTestCaseTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    /**
     * PHPUnit setUp for setting up the module.
     *
     * Note: Child classes that define a setUp method must call
     * parent::setUp().
     */
    public function setUp()
    {
        $app = new Application();
        $config = [
            'env'=>'dev',
            'blogdata.provider'     => "Eloquent",
//    'blogdata.provider'   => "PO",
            'capsule.connections' => [
                "dev"=>[
                    'driver'    => 'sqlite',
                    'database'  => ':memory:',
                    'prefix'    => '',
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                ],
            ],
        ];
        foreach ($config as $k=>$v) {
            $app[$k] = $v;
        }
        $eloquent = new Eloquent();
        $app->register($eloquent);
        $blog = new BlogData();
        $app->register($blog);
        $app->boot();

        $this->app = $app;
    }

    public function testInsert () {
        $app = $this->app;
        /* @var $entryService EntryRepositoryInterface */
        $entryService = $app['blogdata.entry'];
        /* @var $entrySchema \C\BlogData\Eloquent\Schema */
        $entrySchema = $app['blogdata.schema'];

        try{
            $entrySchema->dropTables();
        }catch (\Exception $ex){ }

        $entrySchema->createTables();

        $entry = new Entry();
        $entry->title = 'title;';
        $entry->author = 'title;';
        $entry->img_alt = 'title;';
        $entry->content = 'title;';
        $entry->status = 'title;';
        $entry->created_at = date('Y-m-d');
        $entry->updated_at = date('Y-m-d');
        unset($entry->comments);

        $insertedId = $entryService->insert($entry);

        var_dump($insertedId);

    }
}
