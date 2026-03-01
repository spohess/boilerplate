# Estrutura do Repositório

Visão geral da organização de arquivos e diretórios do projeto **Step Forward** — uma aplicação Laravel 12 que implementa os padrões Saga Orchestration e Queue com Dead Letter Queue.

---

## Raiz do Projeto

```
step-forward/
├── app/                    # Código da aplicação
├── bootstrap/              # Inicialização do framework
├── config/                 # Arquivos de configuração
├── database/               # Migrations, factories e seeders
├── docker/                 # Configurações Docker (Sail)
├── docs/                   # Documentação do projeto
├── public/                 # Entry point web (index.php)
├── routes/                 # Definição de rotas
├── storage/                # Logs, cache, uploads
├── tests/                  # Suite de testes (Pest)
├── vendor/                 # Dependências Composer
├── artisan                 # CLI do Laravel
├── compose.yaml            # Docker Compose
├── composer.json           # Dependências PHP
├── phpunit.xml             # Configuração do PHPUnit
└── pint.json               # Configuração do Laravel Pint
```

---

## `app/` — Código da Aplicação

```
app/
├── Console/
│   └── Commands/
│       └── QueueReprocessCommand.php       # Reprocessa mensagens da DLQ
│
├── Domains/
│   └── Order/                              # Domínio de pedidos
│       ├── Handlers/
│       │   └── SendOrderNotificationHandler.php  # Handler de fila para notificações
│       └── Steps/                          # Etapas da saga de pedidos
│           ├── CreateOrderStep.php
│           ├── ProcessPaymentStep.php
│           └── ConfirmOrderStep.php
│
├── Events/
│   └── OrderConfirmedEvent.php
│
├── Http/
│   ├── Controllers/
│   │   ├── Controller.php                  # Controller base
│   │   └── OrderController.php            # Endpoint de criação de pedido
│   └── Requests/
│       └── StoreOrderRequest.php          # Validação da requisição
│
├── Listeners/
│   └── SendOrderConfirmedNotificationListener.php
│
├── Models/
│   ├── Order.php                          # Modelo Eloquent de pedido
│   ├── SagaFailureLog.php                 # Registro de falhas da saga
│   └── User.php
│
├── Providers/
│   ├── AppServiceProvider.php
│   └── QueueRouteServiceProvider.php      # Registra rotas de filas
│
└── Supports/                              # Infraestrutura e contratos transversais
    ├── Abstracts/
    │   └── Input.php                      # Classe base para inputs
    ├── Interfaces/
    │   ├── DTOInterface.php
    │   ├── EntitytInterface.php
    │   ├── InputInterface.php
    │   ├── ServicesInterface.php
    │   └── ValueObjectInterface.php
    ├── Queue/                             # Sistema de mensageria
    │   ├── Abstracts/
    │   │   └── AbstractQueueHandler.php   # Handler base com lógica de retry/DLQ
    │   ├── Interfaces/
    │   │   └── QueueMessageInterface.php
    │   ├── QueueJob.php                   # Job genérico (ShouldQueue)
    │   ├── QueueMessage.php               # Envelope de mensagem imutável
    │   ├── QueueProducer.php              # Publicador de mensagens
    │   └── QueueRouter.php               # Registro de fila → handler
    ├── Saga/                              # Sistema de orquestração de saga
    │   ├── SagaContext.php               # Estado compartilhado entre etapas
    │   ├── SagaOrchestrator.php          # Motor de orquestração
    │   ├── SagaStepInterface.php         # Contrato de etapa (run + rollback)
    │   └── StepDispatchesEventInterface.php
    └── Services/                          # Adaptadores de serviços externos
        ├── Notification/
        │   ├── NotificationDTO.php
        │   ├── NotificationInput.php
        │   └── NotificationService.php
        └── PaymentGateway/
            ├── PaymentDTO.php
            ├── PaymentInput.php
            ├── PaymentService.php
            ├── RefundDTO.php
            ├── RefundInput.php
            └── RefundService.php
```

### Responsabilidades por Diretório

| Diretório | Responsabilidade |
|-----------|-----------------|
| `Console/Commands/` | Comandos Artisan customizados |
| `Domains/` | Lógica de negócio organizada por domínio |
| `Domains/*/Steps/` | Etapas da saga (implementam `SagaStepInterface`) |
| `Domains/*/Handlers/` | Handlers de fila (estendem `AbstractQueueHandler`) |
| `Http/Controllers/` | Recebe requisições HTTP, delega para a saga |
| `Http/Requests/` | Form Requests com regras de validação |
| `Models/` | Modelos Eloquent |
| `Providers/` | Service providers da aplicação |
| `Supports/Abstracts/` | Classes base reutilizáveis |
| `Supports/Interfaces/` | Contratos da aplicação |
| `Supports/Queue/` | Infraestrutura de mensageria (ver `docs/QUEUE_PATTERN.md`) |
| `Supports/Saga/` | Infraestrutura de orquestração (ver `docs/SAGA.md`) |
| `Supports/Services/` | Integrações com serviços externos |

---

## `config/` — Configuração

```
config/
├── app.php           # Nome, timezone, locale, providers
├── auth.php          # Guards e providers de autenticação
├── cache.php         # Driver e TTL do cache
├── database.php      # Conexões de banco de dados
├── filesystems.php   # Discos de armazenamento
├── logging.php       # Canais de log
├── mail.php          # Configuração de e-mail
├── queue.php         # Drivers e configurações de fila
└── services.php      # Serviços de terceiros
```

---

## `database/` — Banco de Dados

```
database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000001_create_cache_table.php
│   ├── 0001_01_01_000002_create_jobs_table.php
│   ├── 2026_02_21_141123_create_orders_table.php
│   └── 2026_02_21_150147_create_saga_failure_logs_table.php
├── factories/
│   ├── OrderFactory.php
│   └── UserFactory.php
└── seeders/
    └── DatabaseSeeder.php
```

---

## `routes/` — Rotas

```
routes/
├── api.php        # POST /api/orders → OrderController
├── web.php        # Rotas web (não utilizadas)
└── console.php    # Comandos via rota (não utilizados)
```

---

## `tests/` — Testes

```
tests/
├── Feature/
│   ├── AbstractQueueHandlerTest.php
│   ├── OrderFlowTest.php
│   ├── QueueJobTest.php
│   ├── QueueProducerTest.php
│   ├── QueueReprocessCommandTest.php
│   ├── QueueRouterTest.php
│   ├── SagaFailureLogTest.php
│   ├── SendOrderConfirmedNotificationListenerTest.php
│   └── SendOrderNotificationHandlerTest.php
├── Unit/
│   ├── ExampleTest.php
│   └── QueueMessageTest.php
├── Fixtures/
│   └── FailingStep.php     # Auxiliar para testar falhas na saga
├── Pest.php                # Configuração global do Pest
└── TestCase.php            # Caso base de teste
```

---

## `docs/` — Documentação

```
docs/
├── REPOSITORY_STRUCTURE.md    # Este arquivo — visão geral da estrutura
├── SAGA.md                    # Padrão Saga Orchestration
└── QUEUE_PATTERN.md           # Padrão de mensageria com Retry e DLQ
```

---

## `bootstrap/` — Inicialização

```
bootstrap/
├── app.php          # Configuração da aplicação (middleware, exceções, rotas)
└── providers.php    # Registro de service providers
```

No Laravel 12, `bootstrap/app.php` substitui o `Kernel.php`. Middleware, tratamento de exceções e arquivos de rota são registrados aqui de forma declarativa.

---

## Fluxo Principal da Aplicação

```
POST /api/orders
    └── StoreOrderRequest (validação)
        └── OrderController
            └── SagaOrchestrator
                ├── CreateOrderStep     → Order criado no banco
                ├── ProcessPaymentStep  → Pagamento processado via PaymentService
                └── ConfirmOrderStep    → Order confirmado + evento disparado
                                            └── SendOrderConfirmedNotificationListener
                                                    └── QueueProducer → fila
                                                            └── SendOrderNotificationHandler
```

Em caso de falha em qualquer etapa, o `SagaOrchestrator` executa `rollback()` em ordem inversa (LIFO).

---

## Convenções do Projeto

- **Linguagem:** Português nos comentários, mensagens e documentação
- **Estilo de código:** Laravel Pint (`vendor/bin/pint --dirty`)
- **Testes:** Pest 4 — rodar com `php artisan test --compact`
- **Banco de dados:** SQLite em desenvolvimento, MySQL em produção
- **Fila:** `sync` em testes, configurável por ambiente em produção
- **Namespacing:** PSR-4, raiz `App\`
