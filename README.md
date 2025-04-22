# ElBarber - Sistema de Gerenciamento de Barbearia

ElBarber é um sistema de gerenciamento de barbearia com controle de acesso baseado em funções (RBAC - Role-Based Access Control). O sistema permite gerenciar usuários, funções e permissões de forma eficiente e segura.

## Funcionalidades

### Gerenciamento de Usuários
- Cadastro e gerenciamento de usuários
- Atribuição de funções aos usuários
- Autenticação segura
- Recuperação de senha

### Controle de Acesso (RBAC)
- Gerenciamento de funções (roles)
- Gerenciamento de permissões
- Atribuição de permissões às funções
- Verificação automática de permissões nas rotas

### Interface Administrativa
- Dashboard com visão geral do sistema
- Interface moderna e responsiva usando AdminLTE
- Navegação intuitiva
- Mensagens de feedback para ações do usuário

## Tecnologias Utilizadas

- PHP 8.x
- Laravel 10.x
- MySQL 5.7+
- AdminLTE 3.2
- Bootstrap 4
- Font Awesome 5

## Requisitos do Sistema

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Apache ou Nginx
- Extensões PHP:
  - BCMath
  - Ctype
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML

## Instalação

1. Clone o repositório:
```bash
git clone https://seu-repositorio/elbarber.git
cd elbarber
```

2. Instale as dependências do Composer:
```bash
composer install
```

3. Copie o arquivo de ambiente e gere a chave da aplicação:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure o banco de dados no arquivo `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elbarber
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

5. Execute as migrações e seeders:
```bash
php artisan migrate
php artisan db:seed
```

6. Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```

7. Acesse o sistema:
- URL: `http://localhost:8000`
- Email: `admin@elbarber.com`
- Senha: `password`

## Estrutura do Projeto

```
elbarber/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Controladores da aplicação
│   │   └── Middleware/     # Middlewares, incluindo verificação de permissões
│   │   
│   └── Models/            # Modelos do Eloquent
├── database/
│   ├── migrations/        # Migrações do banco de dados
│   └── seeders/          # Seeders para dados iniciais
├── resources/
│   └── views/            # Views Blade
│       ├── auth/         # Views de autenticação
│       ├── layouts/      # Layouts base
│       ├── users/        # Views de gerenciamento de usuários
│       ├── roles/        # Views de gerenciamento de funções
│       └── permissions/  # Views de gerenciamento de permissões
└── routes/
    └── web.php          # Definições de rotas
```

## Funções Padrão

O sistema vem com três funções predefinidas:

1. **Administrador**
   - Acesso total ao sistema
   - Pode gerenciar usuários, funções e permissões

2. **Gerente**
   - Pode gerenciar usuários
   - Acesso limitado a funções administrativas

3. **Funcionário**
   - Acesso básico ao sistema
   - Visualização de informações limitadas

## Segurança

- Autenticação robusta
- Proteção contra CSRF
- Senhas criptografadas
- Controle de acesso baseado em funções
- Validação de dados em todas as entradas

## Contribuição

1. Faça um Fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## Suporte

Para suporte, envie um email para suporte@elbarber.com ou abra uma issue no repositório.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
