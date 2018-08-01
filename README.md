## Messenger demo
-
### Дисклеймер

Этот репозиторий является исключительно примером и демонстрацией возможностей использования и настройки компонента [Messenger](https://symfony.com/doc/current/components/messenger.html) в связке с библиотекой [Enqueue](https://github.com/php-enqueue/enqueue-dev). Не надо рассматривать данный код, как production-решение.

### Установка и запуск

* запустите:
```
docker-compose up --build
```

* сделайте запрос на ресурс:
```
http://0.0.0.0/gitlab/mr?targetBranch=issue-1&sourceBranch=issue-2
```

* откройте веб-клиент RabbitMQ (guest/guest):
```
http://0.0.0.0:15672/#/queues/%2F/gitlab
```
и убедитесь, что сообщение было передано в брокер в очередь `gitlab`

* запустите консьюмер:
```
docker exec -it messenger-demo-php php bin/console messenger:consume-messages gitlab.command --limit=1 -vvv
```

* убедитесь, что сообщение было прочитано из очереди `gitlab`, но появилось новое сообщение в очереди `jira`

* запустите консьюмер, чтобы прочитать его:
```
docker exec -it messenger-demo-php php bin/console messenger:consume-messages jira.command --limit=1 -vvv
```