# Faltômetro & Calculadora de Notas

Este é um projeto desenvolvido em Laravel para ajudar estudantes universitários a gerenciar suas faltas e calcular suas médias de forma simples e eficaz. A aplicação permite que cada usuário cadastre suas matérias por semestre, registre faltas e insira notas e pesos de avaliações para obter a média parcial.

## Funcionalidades Principais

-   **Autenticação de Usuários**: Sistema completo de registro, login e logout com Laravel Breeze.
-   **CRUD de Matérias**: Crie, visualize, edite e delete suas matérias a cada semestre.
-   **Faltômetro Inteligente**:
    -   Registre faltas por data e quantidade.
    -   Visualize o total de faltas e o limite permitido.
    -   Acompanhe seu progresso com uma barra visual que muda de cor conforme se aproxima do limite.
-   **Calculadora de Notas Flexível**:
    -   Adicione avaliações (provas, trabalhos, etc.) com nomes e pesos personalizados.
    -   Insira suas notas para cada avaliação.
    -   O sistema calcula e exibe sua média parcial ponderada em tempo real.

---

---

## Como Rodar o Projeto (Guia Rápido)

### Pré-requisitos
- PHP 8.2+
- Composer
- Node.js & NPM
- Banco de dados MySQL (Xampp)

### 1. Preparação

**Clone o projeto e entre na pasta:**
```bash
# Se estiver usando Git
git clone https://github.com/MarcosgAbreu/faltometro.git
cd faltometro
```

**Instale as dependências:**
```bash
composer install
npm install
```

### 2. Banco de Dados

**Execute as migrações** para criar todas as tabelas, caso nao tenha criado o banco com o nome faltometro, aceite a criação do mesmo com "yes":
```bash
php artisan migrate
```

### 3. Iniciar a Aplicação

Você precisa de **dois terminais** abertos.

**Terminal 1 (Servidor PHP):**
```bash
php artisan serve
```

**Terminal 2 (Compilador de CSS/JS):**
```bash
npm run dev
```

---
**Pronto!** Acesse `http://127.0.0.1:8000` no seu navegador.