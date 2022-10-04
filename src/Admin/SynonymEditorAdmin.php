<?php

namespace DNADesign\SilverstripeSearchUtilities\Admin;

use DNADesign\SilverstripeSearchUtilities\Model\Synonym;
use DNADesign\SilverstripeSearchUtilities\Traits\SynonymsFileTrait;
use SilverStripe\Admin\ModelAdmin;

class SynonymEditorAdmin extends ModelAdmin
{
    use SynonymsFileTrait;

    private static $menu_title = 'Synonym Editor';

    private static $url_segment = 'synonyms';

    private static $managed_models = [
        Synonym::class
    ];

    private static $menu_icon_class = 'font-icon-search';

    /**
     * Adds warning message before the gridfield if required
     *
     * @param int|null $id
     * @param \SilverStripe\Forms\FieldList $fields
     * @return \SilverStripe\Forms\Form A Form object with one tab per {@link \SilverStripe\Forms\GridField\GridField}
     */
    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        $this->outputWarningField($form->Fields(), 'DNADesign-SilverstripeSearchUtilities-Model-Synonym');

        return $form;
    }
}