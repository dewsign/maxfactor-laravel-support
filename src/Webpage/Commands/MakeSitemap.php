<?php

namespace Maxfactor\Support\Webpage\Commands;

use Illuminate\Console\Command;
use Laravelium\Sitemap\Sitemap;

class MakeSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:sitemap';

    protected $sitemap;

    protected $outputType = 'xml';
    protected $outputFilename = 'sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap files for the entire site';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Sitemap $sitemap)
    {
        parent::__construct();

        $this->sitemap = $sitemap;
        $this->sitemap->add(\URL::to('/'));
    }

    /**
     * Populate the sitemap. This method should be overloaded to add content.
     *
     * @param Sitemap $sitemap
     * @return void
     */
    public function populate($sitemap)
    {
        //
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * Populate the sitemap. This method should be overloaded to add content.
         */
        $this->populate($this->sitemap);

        /**
         * Get the sitemap and save it to /public/sitemap.xml
         */
        return $this->sitemap->store('xml', 'sitemap');
    }
}
