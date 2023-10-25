# teste_kanastra
front + backend + docker atrelado

# docker-web

Estrutura básica para docker Apache que pode servir como substitudo para o XAMPP.

- PHP 8.1
- mailhog - FAKE SMTP para testes, endereço para acesso: http://localhost:8025/
- REDIS - para gestão de cache
- src: Pasta para os scripts relacionados

## Comandos referenciando o docker

### Comando para build 
```
docker-compose up -d --force-recreate --build 
```

### Comando para iniciar o docker

Caso de algum problema de conflito se lembre de derrubar outras instancias do docker.

```
docker-compose up -d
```


### Para entrar no bash do docker

```
docker exec -it apache_web /bin/bash   
```

## Para adicionar o HOST

Ex: no Ubuntu
```
sudo nano /etc/hosts 
```

Add. na ultima linha preferencialmente 

```
127.0.0.1   api.local
```

## Softwares recomendados

- Gestor de Banco de dados: https://snapcraft.io/dbeaver-ce

### Comando para instalação Ubuntu

```
    snap install dbeaver-ce
```