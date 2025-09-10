# Instruções para o Sistema de Biblioteca

## Configuração do Banco de Dados

O banco de dados foi configurado com sucesso. Aqui estão os detalhes:

- **Nome do Banco de Dados**: biblioteca
- **Usuário**: root
- **Senha**: (sem senha)
- **Host**: localhost

## Como Acessar o Sistema

1. Certifique-se de que o XAMPP está em execução (Apache e MySQL)
2. Acesse o sistema através do URL: http://localhost/biblioteca5/

## Credenciais de Acesso

Existem dois usuários configurados no sistema:

### Administrador Principal
- **Usuário**: admin
- **Nome**: Rogério Rocha
- **Senha**: admin

### Usuário Secundário
- **Usuário**: angel
- **Nome**: Vida Informatico
- **Senha**: angel123

## Funcionalidades Disponíveis

O sistema possui as seguintes funcionalidades:

- Gerenciamento de Livros
- Gerenciamento de Autores
- Gerenciamento de Editoras
- Gerenciamento de Estudantes
- Gerenciamento de Empréstimos
- Gerenciamento de Reservas
- Gerenciamento de Usuários
- Configurações do Sistema

## Importação do Banco de Dados

Caso seja necessário reimportar o banco de dados, você pode:

1. Acessar o script de importação: http://localhost/biblioteca5/importar_bd.php
2. Ou importar manualmente através do phpMyAdmin: http://localhost/phpmyadmin/

## Estrutura do Banco de Dados

O banco de dados contém as seguintes tabelas:

- autor
- configuracion
- detalle_permisos
- editorial
- estudiante
- libro
- materia
- permisos
- prestamo
- reservas
- usuarios