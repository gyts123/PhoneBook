# Phone Book

## Notes

- Ability to register/login.
- Added CRUD functionality to phone book entries.
- Users can view their created phone book entries.
- Users can share their registered phone book entries with other users.
- Users can cancel sharing entries with other users.
- You can run Unit and Feature tests by running ``` ./bin/phpunit ``` command in the main project directory

## Installation

Note: you may need to run some commands with ``` sudo ``` keyword depending on you configuration

1.Clone the repository

```shell script
git clone https://github.com/gyts123/PhoneBook.git
```

2.Build docker containers

```shell script
cd docker/
docker-compose build
```

3.Install composer dependencies

```shell script
docker-compose run php composer install
```

4.Run docker containers

```shell script
docker-compose up -d
```
5.Find out mysql container ip address

```shell script
docker inspect docker_mysql_1 | grep "IPAddress"

example output:
  "SecondaryIPAddresses": null,
  "IPAddress": "",
          "IPAddress": "172.20.0.2",
```

6.Copy the address to .env file to access the database

7.Set up database tables

```shell script
php bin/console doctrine:migrations:migrate
```

8.Access the app via url

```
http://127.0.0.1:8080/
```

## Suggestion to further improve task

The task in my opinion was quite well made. It was fun and interesting to code this task, so i suggest keeping the task as it is.

