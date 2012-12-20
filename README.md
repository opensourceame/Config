This is a flexible config class.

The objective of this Config handler is to be able to read and write
configuration in a predictable, standard manner from a variety of formats.

Formats include:

* YAML
* JSON
* XML
* Arrays
* Redis
* DB (using PDO)
* Command line (using CLI arguments)

Config, once parsed, is represented in a namespaced fashion like so:

* server:db:host => localhost
* server:db:db   => my_database

Thus to get the host name for the database server you would:

$config->get('server:db:host')

and, of course, there's an equivalent setter. You can also get multiple options using a wildcard:

$config->get('server:db:*') // returns an array of db settings
