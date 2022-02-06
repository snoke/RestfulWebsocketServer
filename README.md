# RestfulWebsocketServer
Command driven Symfony6 Websocket Server with Restful Commands, JSON Requests and Responses 

supports different response strategies (result callback or broadcasting to all connections)

## usage 
### start websocket server
```
php bin/console server:start
```

then you can connect via websocket and run json requests in following format on your entities:
```
{ 'rest:post User 14 {username:'john doe'}' }
```
```
{ 'rest:get User 14' }
```
result will look like this
```
{ action: 'rest:get',
  params: { entity: 'User', id:14}
  data: {
    id:14,
    username: 'john doe',
    [...]
  }
}
```
