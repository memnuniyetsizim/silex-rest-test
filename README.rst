Rest Test Project
=================

Simple rest service for testing purpose.

Run with `php -S 127.0.0.1:8888 -t web web/index_dev.php` to see in browser.

Run codeception API tests after running below `./vendor/bin/codecept run


Sample Curl Requests
====================

// Get token
`curl -X GET http://127.0.0.1:8888/api/login -H 'Content-Type: application/json' -w "\n"`

`curl -X GET http://127.0.0.1:8888/api/user -d '{"token":""}' -H 'Content-Type: application/json' -w "\n"`

`curl -X POST http://127.0.0.1:8888/api/user -d '{"token":"","username":"cukubik","description":"naber"}' -H 'Content-Type: application/json' -w "\n"`

`curl -X PUT http://127.0.0.1:8888/api/user/4 -d '{"token":"","username":"3cukubik","description":"11111naber"}' -H 'Content-Type: application/json' -w "\n"`

`curl -X DELETE http://127.0.0.1:8888/api/user/4 -d '{"token":""}' -H 'Content-Type: application/json' -w "\n"`

