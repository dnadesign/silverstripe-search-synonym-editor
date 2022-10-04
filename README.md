# Silverstripe Search Synonym Editor

A module that allow's editing of Solr Search Synonyms

## Requirements

* Silverstripe Recipe Solr search 2.11

### synonyms.txt file

Ensure that the synonyms.txt file exists in the following location:

```
BASE_PATH . '/app/conf/extras/synonyms.txt';
```

## Installation

Include the following in your composer.json and run composer update:

```bash
"require": {
    dnadesign/silverstripe-search-synonym-editor
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