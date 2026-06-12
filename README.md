# 🎓 Central de Estágios - FSA

Sistema de gerenciamento de estágios da Fundação Santo André com banco de dados JSON para armazenamento de credenciais.

## 🆕 Novidades - Sistema de Banco de Dados

Este projeto agora inclui um **banco de dados fictício em JSON** que salva automaticamente o CPF e senha (criptografada) de todos os usuários que fazem login.

### ✨ Características

- ✅ Salvamento automático de login e senha
- ✅ Senhas criptografadas com Bcrypt (seguro e irreversível)
- ✅ Interface administrativa para visualizar usuários
- ✅ API JSON para acesso aos dados
- ✅ Sem validação de credenciais (aceita qualquer login)
- ✅ Pronto para deploy no Render

## 🚀 Como Usar Localmente

### 1. Iniciar o servidor

```bash
cd central-estagios-main
php -S localhost:8000
```

### 2. Acessar o sistema

- **Login:** http://localhost:8000/login.php
- **Dashboard:** http://localhost:8000/dashboard.php
- **Usuários (Admin):** http://localhost:8000/admin-users.php
- **JSON (API):** http://localhost:8000/view-json.php

### 3. Fazer login

Digite qualquer CPF e senha. Exemplo:
- CPF: `123.456.789-00`
- Senha: `senha123`

Os dados serão salvos automaticamente em `data/users.json`

## 📊 Visualizar Banco de Dados

### Opção 1: Interface Web (Recomendado)

Após fazer login, acesse:
```
http://localhost:8000/admin-users.php
```

Você verá uma tabela com:
- ID do usuário
- CPF formatado
- Senha criptografada (hash)
- Data de criação
- Último login

### Opção 2: JSON Bruto

Acesse:
```
http://localhost:8000/view-json.php
```

### Opção 3: Arquivo Direto

Abra o arquivo:
```
central-estagios-main/data/users.json
```

## 🌐 Deploy no Render

### Passo a Passo Completo

Consulte o guia detalhado: **[GUIA_DEPLOY_RENDER.md](GUIA_DEPLOY_RENDER.md)**

### Resumo Rápido

1. Suba o projeto para o GitHub
2. Conecte o repositório no Render
3. Configure:
   - Root Directory: `central-estagios-main`
   - Start Command: `php -S 0.0.0.0:$PORT`
4. Deploy!

### URLs após Deploy

```
🔗 Site: https://SEU_APP.onrender.com
🔗 Login: https://SEU_APP.onrender.com/login.php
🔗 Admin: https://SEU_APP.onrender.com/admin-users.php
🔗 JSON: https://SEU_APP.onrender.com/view-json.php
```

## 📁 Estrutura do Projeto

```
central-estagios-main/
├── data/
│   └── users.json              # 🆕 Banco de dados de usuários
├── includes/
│   ├── auth.php                # 🆕 Funções de autenticação
│   ├── config.php
│   ├── header.php
│   └── footer.php
├── admin-users.php             # 🆕 Página de visualização de usuários
├── view-json.php               # 🆕 API JSON
├── index.php                   # ✏️ Modificado (salva usuários)
├── login.php                   # ✏️ Modificado (atributos name)
├── dashboard.php
├── profile.php
├── jobs.php
├── README.md                   # 🆕 Este arquivo
├── README_BANCO_DADOS.md       # 🆕 Documentação técnica
└── GUIA_DEPLOY_RENDER.md       # 🆕 Guia de deploy
```

## 🎯 Para Apresentação ao Professor

### 1. Demonstrar o Sistema

1. Acesse a página de login
2. Digite qualquer CPF e senha
3. Mostre que foi redirecionado para o dashboard
4. Acesse `admin-users.php` (ícone de banco de dados no menu)
5. Mostre a tabela com os dados salvos

### 2. Destacar Pontos Importantes

✅ **Salvamento Automático**
- Dados são salvos ao fazer login

✅ **Segurança**
- Senhas criptografadas com Bcrypt
- Hash irreversível (não dá para descobrir a senha)

✅ **Interface Administrativa**
- Não precisa abrir arquivos do projeto
- Tudo visível pela interface web

✅ **Banco de Dados JSON**
- Arquivo `data/users.json`
- Simples e funcional

### 3. URLs para Compartilhar

Após fazer deploy no Render, compartilhe:

```
📧 Para o Professor:

Site: https://SEU_APP.onrender.com
Login: https://SEU_APP.onrender.com/login.php
Admin (Banco): https://SEU_APP.onrender.com/admin-users.php

Credenciais de teste:
CPF: 123.456.789-00
Senha: senha123
```

## 📚 Documentação

- **[README_BANCO_DADOS.md](README_BANCO_DADOS.md)** - Documentação técnica completa
- **[GUIA_DEPLOY_RENDER.md](GUIA_DEPLOY_RENDER.md)** - Guia de deploy passo a passo
- **[PLANO_BANCO_DADOS.md](PLANO_BANCO_DADOS.md)** - Plano de implementação

## 🔒 Segurança

### Criptografia de Senhas

As senhas são criptografadas usando **Bcrypt**:

```php
$hash = password_hash($password, PASSWORD_BCRYPT);
// Resultado: $2y$12$RZ6zFt9vytQOYCnfc4cIuO...
```

**Características:**
- ✅ Algoritmo lento (dificulta ataques)
- ✅ Salt automático (cada hash é único)
- ✅ Irreversível (impossível recuperar senha)
- ✅ Padrão da indústria

### Exemplo

```
Senha original: "senha123"
Hash salvo: "$2y$12$RZ6zFt9vytQOYCnfc4cIuOfZpyF8HQum8Sx3mRgJeiKK95MzKNfz2"
```

Mesmo com acesso ao arquivo `users.json`, é impossível descobrir a senha original.

## 🧪 Testar o Sistema

### Script de Teste Incluído

Execute:
```bash
cd central-estagios-main
php test_login.php
```

Este script irá:
1. Criar um usuário de teste
2. Tentar criar o mesmo usuário novamente
3. Criar um segundo usuário
4. Exibir o conteúdo do banco de dados

## ⚠️ Observações

### Para Ambiente de Produção

Este sistema usa JSON como banco de dados para fins **acadêmicos/demonstração**. Para produção real, considere:

- ✅ Migrar para banco de dados relacional (MySQL, PostgreSQL)
- ✅ Adicionar validação de credenciais
- ✅ Implementar recuperação de senha
- ✅ Adicionar autenticação de dois fatores
- ✅ Implementar rate limiting

### Sobre o Render (Plano Free)

- ⚠️ Sistema de arquivos é efêmero (dados podem ser perdidos)
- ⚠️ App "hiberna" após 15 minutos de inatividade
- ⚠️ Primeira requisição pode ser lenta (30-60s)
- ✅ Perfeito para demonstrações acadêmicas

## 🛠️ Tecnologias

- **Backend:** PHP 7.4+
- **Frontend:** HTML5, TailwindCSS, Font Awesome
- **Banco de Dados:** JSON (arquivo)
- **Criptografia:** Bcrypt (via `password_hash()`)
- **Deploy:** Render.com

## 📞 Suporte

Se tiver dúvidas:

1. Consulte a documentação em `README_BANCO_DADOS.md`
2. Veja o guia de deploy em `GUIA_DEPLOY_RENDER.md`
3. Execute o script de teste: `php test_login.php`

## ✅ Checklist de Funcionalidades

- [x] Sistema de login funcional
- [x] Salvamento automático de credenciais
- [x] Criptografia de senhas com Bcrypt
- [x] Interface administrativa para visualizar usuários
- [x] API JSON para acesso aos dados
- [x] Prevenção de duplicatas (mesmo CPF)
- [x] Rastreamento de último login
- [x] Documentação completa
- [x] Guia de deploy para Render
- [x] Script de testes

---

**Desenvolvido para a Fundação Santo André** 🎓

Sistema de banco de dados implementado com sucesso! ✅