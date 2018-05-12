# Projeto db

Projeto sendo feito com fins de aprendizagem sobre banco de dados. Por isso não poderemos usar as facilidades do laravel/eloquent quando a queries no banco. 

* ### Laravel
É um framework mvc que tem muitas facilidades, nos vamos usar: autenticação, rotas, estrutura MVC(model view control).  

* Rodando: execute "php artisan serve" na raiz do projeto.
* Criando Alguma coisa: "php artisan make: ...", exemplos: "php artisan make: controller UsuarioController", "php artisan make: model UsuarioModel" e etc.
* Algumas factories e seeders estão feitos para gerar alguma quantidade de usuarios, comentarios e obras, para usar: php artisan db:seed

* ### XAMMP
XAMMP é um conjunto de softwares, includindo o servidor Apache e o mysql, que vamos usar como banco de dados. Ao startar os dois, temos acesso ao "phpmyadmin" que ajuda a gerenciar o banco de dados(criar o banco, editar tabelas, criar tabelas e etc)

* ### QFModel
Como não podemos usar os metodos de banco de dados no model do Laravel. Estamos fazendo alguns metodos/classes customizados para mapeamento do banco, contido em App\QFEloquent. Uso:

* Quando você extende um QFModel, você tem acesso a funções de mapeamento como: mySave(), que salva o modelo no banco, myFind($id) que busca a linha no banco e transforma em objeto e $myUpdate(), que atualiza um registro no banco.
* Cada modelo tem três tipos de relacionamento: myhasMany, mybelongsTo, mybelongsToMany, que representam os relacionamentos entre duas entidades, nesses relacionamentos tempos a função get(), que busca os dados do lado oposto do relacionamento. Por exemplo: buscar posts de um usuario. Em alguns dos relacionamentos, alem desse metodo tempos, o add(), para adicionar um dado ao relacionamento, check() checa se relacionamento existe, count() conta quandos relacionamentos existem com o modelo e etc.
 

* ### Adminlte
Adminlte é um template usado para dashboars, contém com varios estilos e layouts predefinidos. Laravel-AdminLTE(https://github.com/jeroennoten/Laravel-AdminLTE#5-configuration) é a integração desse template com o laravel. Vai nos ajudar  a fazer a interface gráfica rapidamente.

* ### Esquema do banco de dados  
![Image of Yaktocat](https://i.imgur.com/N5S0dPv.png)

esquema feito usando schema-designer: https://github.com/Agontuk/schema-designer
