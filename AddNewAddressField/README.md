# Module Bluethinkinc AddNewAddressField

    ``bluethinkinc/module-addnewaddressfield``

- [Main Functionalities](#markdown-header-main-functionalities)
- [Installation](#markdown-header-installation)
- [Configuration](#markdown-header-configuration)
- [Specifications](#markdown-header-specifications)
- [Attributes](#markdown-header-attributes)


## Main Functionalities
This is used for adding custom field to shipping address.

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

- Unzip the zip file in `app/code/Bluethinkinc`
- Enable the module by running `php bin/magento module:enable Bluethinkinc_AddNewAddressField`
- Apply database updates by running `php bin/magento setup:upgrade`
- compilation by running `php bin/magento setup:di:compile`
- Static Content deploy by running `php bin/magento setup:static-content:deploy`
- Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

- Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
- Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
- Install the module composer by running `composer require bluethinkinc/module-addnewaddressfield`
- enable the module by running `php bin/magento module:enable Bluethinkinc_AddNewAddressField`
- apply database updates by running `php bin/magento setup:upgrade`
- compilation by running `php bin/magento setup:di:compile`
- Static Content deploy by running `php bin/magento setup:static-content:deploy`
- Flush the cache by running `php bin/magento cache:flush`


## Configuration

- In the configuration file there are 3 fields:
- Open Admin Panel 
And goto  -> Stores -> Configuration -> BluethinkInc -> Add Address Field
- and click on Add button and add field.

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.


