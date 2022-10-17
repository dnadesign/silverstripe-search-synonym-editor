<?php

namespace DNADesign\SilverstripeSearchUtilities\Model;

use Account\Jobs\UpdateSynonymsTxtFileJob;
use DNADesign\SilverstripeSearchUtilities\Traits\SynonymsFileTrait;
use SilverStripe\ORM\DataObject;
use Symbiote\QueuedJobs\Services\QueuedJobService;

class Synonym extends DataObject
{
    use SynonymsFileTrait;

    private static $table_name = 'Synonym';

    private static $db = [
        'Word' => 'Varchar(255)',
        'Synonym' => 'Varchar(255)',
    ];

    private static $singular_name = 'Synonym';

    private static $plural_name = 'Synonyms';

    private static $summary_fields = [
        'Word' => 'Word',
        'Synonym' => 'Synonym',
        'Title' => 'Search Mapping',
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $this->outputWarningField($fields, 'Word');
        $fields->dataFieldByName('Word')->setDescription('A search term that produces results that the synonym below should also produce.');
        $fields->dataFieldByName('Synonym')->setDescription('A word that means exactly or nearly the same thing as another word.');
        return $fields;
    }

    /**
     * Event handler called after writing to the database.
     * 
     * @uses DataExtension->onAfterWrite()
     */
    public function onAfterWrite()
    {
        parent::onAfterWrite();
        $this->addUpdateSynonymsJobToQueue();
    }

    /**
     * Event handler called after deleting from the database.
     * 
     * @uses DataExtension->onAfterDelete()
     */
    public function onAfterDelete()
    {
        parent::onAfterDelete();
        $this->addUpdateSynonymsJobToQueue();
    }

    /**
     * Ensure the that the synonyms.txt file is updated after dev/build (for deployments etc)
     */
    public function onAfterBuild()
    {
        $this->addUpdateSynonymsJobToQueue();
        $this->extend('onAfterBuild');
    }

    /**
     * Adds the UpdateSynonymsTxtFileJob to the queue
     *
     * @return void
     */
    public function addUpdateSynonymsJobToQueue()
    {
        if($this->synonymsFileExists()) {
            $updateSynonymsJob = new UpdateSynonymsTxtFileJob();
            singleton(QueuedJobService::class)->queueJob($updateSynonymsJob);
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->Synonym . ' => ' . $this->Word;
    }
}
