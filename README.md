# Silverstripe Search Synonym Editor

A module that allow's editing of Solr Search Synonyms.

## CMS Usage and Queued Jobs

A synonym is a word that means exactly or nearly the same thing as another word or phrase in the same language. This module adds a Synonyms Editor Model Admin to the CMS menu which allows content editors to edit Solr Search Synonyms.

After editing or deleting a Synonym, the UpdateSynonymsTxtFileJob is added to the queue (this also runs on dev build). This job will add all synonyms to the synonyms.txt file and then enqueue the Solr_Configure dev task as a queued job to reconfigure your search index.

## Requirements

- Silverstripe Recipe Solr search 2.11

### synonyms.txt file

Ensure that the synonyms.txt file exists in the following location:

```
BASE_PATH . '/app/conf/extras/synonyms.txt';
```

See the [File-based configuration documentation](https://github.com/silverstripe/silverstripe-fulltextsearch/blob/3/docs/en/03_configuration.md#file-based-configuration) for details about the 'conf/extras' folder.

## Installation

Include the following in your composer.json and run composer update:

```bash
"require": {
    "dnadesign/silverstripe-search-synonym-editor": "dev-main"
}
```

```bash
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/dnadesign/silverstripe-search-synonym-editor.git"
        }
    ],
```
