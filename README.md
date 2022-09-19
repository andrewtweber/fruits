# fruits

What Fruits are in Season?

Code behind https://fruits.andrew.cool/

(previously whatfruitsareinseason.com)

Old project with some modern updates (composer packages, SASS)

## Installation

After cloning the repository, run

```
composer install
yarn install
yarn run production
```

Copy the file `.env.example` to `.env` and update your database connection and other settings.

Run the SQL query in `database/structure.sql` and populate the table with data.

Finally, make sure that the folder `views/compiled` is writable by your web server.
