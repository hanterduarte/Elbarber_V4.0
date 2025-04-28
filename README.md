# ElBarber - Sistema de Gerenciamento de Barbearia

ElBarber é um sistema completo para gerenciamento de barbearias, permitindo o controle de barbeiros, clientes, agendamentos, serviços e vendas.

## Funcionalidades Principais

### Gerenciamento de Barbeiros
- Cadastro e gerenciamento de barbeiros
- Controle de comissões
- Upload de fotos de perfil
- Status ativo/inativo

### Gerenciamento de Clientes
- Cadastro e gerenciamento de clientes
- Histórico de agendamentos
- Histórico de vendas

### Agendamentos
- Agendamento de serviços
- Seleção de barbeiro
- Controle de horários
- Status do agendamento (agendado, confirmado, concluído, cancelado)

### Serviços
- Cadastro de serviços
- Preços
- Duração
- Status ativo/inativo

### PDV (Ponto de Venda)
- Venda de serviços
- Controle de pagamentos
- Comissões dos barbeiros

## Tecnologias Utilizadas

- PHP 8.2
- Laravel 10.x
- MySQL 8.0
- Bootstrap 5
- AdminLTE 3.2
- Font Awesome 5
- jQuery
- DataTables
- Select2
- Inputmask

## Requisitos do Sistema

- PHP >= 8.2
- Composer
- MySQL >= 8.0
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
  - Fileinfo
  - GD

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/elbarber.git
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

5. Crie o link simbólico para o storage (necessário para upload de imagens):
```bash
php artisan storage:link
```

6. Execute as migrações e seeders:
```bash
php artisan migrate --seed
```

7. Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```

8. Acesse o sistema:
- URL: `http://localhost:8000`
- Email: `admin@elbarber.com`
- Senha: `password`

## Estrutura do Projeto

```
elbarber/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Controladores da aplicação
│   │   │   ├── BarberController.php
│   │   │   ├── ClientController.php
│   │   │   ├── AppointmentController.php
│   │   │   ├── ServiceController.php
│   │   │   └── SaleController.php
│   │   └── Middleware/     # Middlewares
│   ├── Models/            # Modelos do Eloquent
│   │   ├── Barber.php
│   │   ├── Client.php
│   │   ├── Appointment.php
│   │   ├── Service.php
│   │   └── Sale.php
│   └── Providers/         # Provedores de serviço
├── config/               # Arquivos de configuração
├── database/
│   ├── migrations/       # Migrações do banco de dados
│   └── seeders/         # Seeders para dados iniciais
├── public/
│   ├── css/             # Arquivos CSS compilados
│   ├── js/              # Arquivos JavaScript compilados
│   └── storage/         # Arquivos enviados (link simbólico)
├── resources/
│   ├── css/             # Arquivos SCSS/CSS fonte
│   ├── js/              # Arquivos JavaScript fonte
│   └── views/           # Views Blade
│       ├── layouts/     # Layouts base
│       ├── barbers/     # Views de barbeiros
│       ├── clients/     # Views de clientes
│       ├── appointments/ # Views de agendamentos
│       ├── services/    # Views de serviços
│       └── sales/       # Views de vendas
├── routes/
│   └── web.php         # Definições de rotas
└── storage/
    └── app/
        └── public/     # Arquivos enviados (original)
```

## Dependências Frontend

- Bootstrap 5.x
- AdminLTE 3.2.x
- jQuery 3.6.x
- Font Awesome 5.15.x
- DataTables 1.10.x
- Select2 4.1.x
- Inputmask 5.x
- Moment.js 2.29.x
- Tempus Dominus 6.x (Datetime Picker)

## Dependências Backend

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^10.10",
        "laravel/sanctum": "^3.2",
        "laravel/tinker": "^2.8"
    }
}
```

## Manutenção

Para manter o sistema funcionando corretamente:

1. Limpe o cache regularmente:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

2. Otimize o autoloader:
```bash
composer dump-autoload -o
```

3. Faça backup do banco de dados e arquivos enviados regularmente

## Suporte

Para suporte ou sugestões, envie um email para hanterduarte@gmail.com ou abra uma issue no repositório.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
