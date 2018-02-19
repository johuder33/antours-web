## ¿ Como instalar el ambiente de desarrollo ?

El ambiente de desarrollo se instalara de forma sencilla, gracias a [Docker](https://docs.docker.com/install/).

Docker servira para reunir todos los servicios que necesitamos en una imagen (maquina virtual) ya preconfigurada, de esa manera nos olvidamos de configurar servidores, framework, bases de datos, etc.

Entonces para iniciar debemos ejecutar los siguientes comandos:

1. Lo primero que debes hacer es instalar Docker, si es que no lo posees para instalarlo por favor visita el link que cumpla con tu plataforma
  1.1 para [Windows](https://docs.docker.com/docker-for-windows/install/)
  1.2 para [Linux](https://docs.docker.com/docker-for-mac/install/)
  1.3 para [Mac](https://docs.docker.com/install/linux/docker-ce/ubuntu/#set-up-the-repository)
> Si no tienes git instalado recuerda tambine instalarlo, aqui las [instrucciones](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git) para instalar Git segun la plataforma que tienes.

<strong>Una vez instalado `Docker` y `Git` debes abrir y correr los servicios de Docker</strong>

2. Una vez instalado, lo siguiente es ejecutar el siguiente comando en un terminal o consola de comandos
> ```git clone https://github.com/johuder33/antours-environment.git antours-project```
3. Una vez clonado el repositorio debes ingresar a la carpeta `antours-project` que se creo al clonar el repositorio
> ```cd antours-project```
4. Una vez dentro de la carpeta debes ejecutar los siguientes comandos
> ```docker build -t antoursdb .```
5. Una vez ejecutado ese comando, debes ejecutar el siguiente para iniciar los servicios
> ```docker-compose up -d```
Este último comando comenzara a descargar los servicios, configurarlos e instalarlos, deberas esperar a que este comando termine de ejecutarse exitosamente.
6. Una vez terminado el comando de arriba, deberas havcer lo siguiente
> `Espera unos 10 segundos y luego abre el navegador de preferencia Google Chrome`
> Entonces para ingresar a los servicios web tienes lo siguiente
> 1. Sitio Wordpress (Server) `http://localhost:4000`, al colocar esta URL en el navegador podras visualizar el sitio web de wordpress
> 2. Para ingresar a phpmyadmin deberas ingresar `http://localhost:4001` te pedira usuario y contraseña, `usuario: root` y `clave: antourswordpress`, con este podras ingresar y ver las tablas de la base de datos.
7. una vez visitados y visualizado el sitio wordpress, debes ejecutar el siguiente comando.
> `cd wp-content/themes`
> `git clone https://github.com/johuder33/antours-web.git antours`
> `cp -rf antours/plugins /../plugins`

Finalmente es todo lo que se debe hacer para configurar el ambiente de desarrollo del proyecto :sunglasses:

## Happy Coding :sunglasses:

## En la carpeta Plugin existen los plugines que actualmente estan hechos cada cambio que se haga en cada plugin debe ser guardado en su respectiva carpeta.
