<?php

namespace Account\Jobs;

use DNADesign\SilverstripeSearchUtilities\Model\Synonym;
use DNADesign\SilverstripeSearchUtilities\Traits\SynonymsFileTrait;
use Symbiote\QueuedJobs\Jobs\RunBuildTaskJob;
use Symbiote\QueuedJobs\Services\AbstractQueuedJob;
use Symbiote\QueuedJobs\Services\QueuedJob;
use Symbiote\QueuedJobs\Services\QueuedJobService;
use SilverStripe\FullTextSearch\Solr\Tasks\Solr_Configure;

class UpdateSynonymsTxtFileJob extends AbstractQueuedJob
{
    use SynonymsFileTrait;

    /**
     * Constructs the queued jobn
     * @var array params
     */
    public function __construct($params = array())
    {
        $this->currentStep = 0;
        $this->totalSteps = 1;
    }

    /**
     * @return string
     */
    public function getJobType()
    {
        return QueuedJob::QUEUED;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Updating Synonyms Text File';
    }

    /**
     * Writes all synonyms to the synonyms text file and then adds the Solr_Configure job to the queu
     */
    public function process()
    {
        if(!$this->synonymsFileExists()) {
            throw new \Exception($this->getWarningMessage());
        }

        $txt = '';

        // get all synonyms
        $synonyms = Synonym::get();
        foreach ($synonyms as $synonym) {
            $txt .= trim($synonym->Synonym) . ' => ' . trim($synonym->Word) . "\n";
        }

        // write the synonyms to the file
        $file = fopen($this->synonymsFileLocation, 'w');
        fwrite($file, $txt);
        fclose($file);

        // add the Solr_Configure BuildTask to the queue
        $solrConfigJob = new RunBuildTaskJob(Solr_Configure::class);
        singleton(QueuedJobService::class)->queueJob($solrConfigJob);

        $this->currentStep = 1;
        $this->isComplete = true;

        return;
    }
}
