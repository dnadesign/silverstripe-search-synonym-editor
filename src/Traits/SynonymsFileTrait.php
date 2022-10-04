<?php

namespace DNADesign\SilverstripeSearchUtilities\Traits;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;

trait SynonymsFileTrait
{

    /**
     * Absolute location of the synonyms.txt file
     *
     * @var string
     */
    private $synonymsFileLocation = BASE_PATH . '/app/conf/extras/synonyms.txt';

    /**
     * Warning message used in  SynonymEditorAdmin, Synonym and UpdateSynonymsTxtFileJob
     * if the synonyms.txt file doesn't exist
     *
     * @return string
     */
    public function getWarningMessage()
    {
        return 'The synonym\'s files "' . $this->synonymsFileLocation .'" does not exist, please ensure that this file is exists in the required location.';
    }

    /**
     * Adds a warning message to the ModalAdmin and Synonym DataObject if synonyms.txt file doesn't exist in the require location
     *
     * @return  void
     */
    public function outputWarningField(FieldList $fields, $insertBefore)
    {
        if (!$this->synonymsFileExists()) {
            $fields->insertBefore(
                LiteralField::create(
                    'ConfigWarning', 
                    '<p class="message error">
                        ' . $this->getWarningMessage() . '
                    </p>'
                ),
                $insertBefore
            );
        }
    }

    /**
     * Checks if the synonyms.txt file exists in the expected location
     *
     * @return  void
     */
    public function synonymsFileExists()
    {
        return file_exists($this->synonymsFileLocation);
    }
}
