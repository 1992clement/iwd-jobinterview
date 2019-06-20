# IWD backend challenge

## Setup

```bash
cd iwd-jobinterview
composer install
php -S localhost:8080 -t web web/index.php

#Go to http://localhost:8080, you will see "Status OK"
```

## Architecture
### /src/client
- Registers Services
- Define Endpoints
- Instanciate DAO and use it to retrieve and format datas

### /src/DAO
Data Access Object tasked with retrieving and formatting the datas. \
The DAOFactory instanciate the right DAO, depending on the need. \
The folder is organized as follow : \
```
/DAO
  DAOFactory.php
  /Json (method of storage)
    BaseDao.php
    /Question (Ressource accessed)
      DAO.php
```
That way, we can easily add new kind of DAO to access different kind of storage. \
Also, DAO concerning the same kind of storage can share methods through the BaseDao.php \

### /src/Entity
Resources structure definition.

### /src/Interfaces/DAO
Interfaces implemented by the DAO. They are organized by ressource, that way we can change the DAO retrieving a specific resource in the future without impacting the rest of the code.
