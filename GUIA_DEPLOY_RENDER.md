# 🚀 Guia de Deploy no Render

## 📋 Pré-requisitos

- Conta no GitHub
- Conta no Render (https://render.com)
- Projeto já configurado com o banco de dados JSON

## 🔧 Passo 1: Preparar o Projeto para o GitHub

### 1.1 Criar arquivo .gitignore (se não existir)

Crie um arquivo `.gitignore` na raiz do projeto com o seguinte conteúdo:

```
# Arquivos de sistema
.DS_Store
Thumbs.db

# IDEs
.vscode/
.idea/

# Arquivos temporários
*.log
*.tmp

# Não ignorar data/ - queremos que o banco de dados seja versionado
# (para fins de demonstração acadêmica)
```

### 1.2 Verificar arquivos importantes

Certifique-se de que estes arquivos existem:
- ✅ `data/users.json` (banco de dados)
- ✅ `includes/auth.php` (funções de autenticação)
- ✅ `admin-users.php` (página de visualização)
- ✅ `view-json.php` (visualização do JSON)

## 📤 Passo 2: Subir para o GitHub

### 2.1 Inicializar repositório Git

```bash
cd central-estagios-main
git init
git add .
git commit -m "Adicionar sistema de banco de dados JSON"
```

### 2.2 Criar repositório no GitHub

1. Acesse https://github.com
2. Clique em "New repository"
3. Nome: `central-estagios-fsa`
4. Descrição: `Central de Estágios - FSA com banco de dados JSON`
5. Deixe como **Public**
6. **NÃO** marque "Initialize with README"
7. Clique em "Create repository"

### 2.3 Conectar e enviar código

```bash
git remote add origin https://github.com/SEU_USUARIO/central-estagios-fsa.git
git branch -M main
git push -u origin main
```

## 🌐 Passo 3: Deploy no Render

### 3.1 Criar Web Service

1. Acesse https://dashboard.render.com
2. Clique em "New +" → "Web Service"
3. Conecte sua conta do GitHub (se ainda não conectou)
4. Selecione o repositório `central-estagios-fsa`
5. Clique em "Connect"

### 3.2 Configurar o Web Service

Preencha os campos:

**Name:** `central-estagios-fsa`

**Region:** `Oregon (US West)` (ou mais próximo)

**Branch:** `main`

**Root Directory:** `central-estagios-main`

**Runtime:** `Docker` (se tiver Dockerfile) OU `Native Environment`

**Build Command:** (deixe vazio se usar Native)

**Start Command:**
```bash
php -S 0.0.0.0:$PORT
```

**Instance Type:** `Free`

### 3.3 Variáveis de Ambiente (opcional)

Clique em "Advanced" e adicione:

```
PORT=10000
```

### 3.4 Deploy

1. Clique em "Create Web Service"
2. Aguarde o deploy (pode levar 2-5 minutos)
3. Quando aparecer "Live", seu site está no ar! 🎉

## 🔗 Passo 4: Acessar o Sistema

Após o deploy, você receberá uma URL como:

```
https://central-estagios-fsa.onrender.com
```

### URLs Importantes para Demonstração

**Para o Professor:**

1. **Página de Login:**
   ```
   https://SEU_APP.onrender.com/login.php
   ```

2. **Página de Usuários (Banco de Dados):**
   ```
   https://SEU_APP.onrender.com/admin-users.php
   ```
   ⚠️ Precisa fazer login primeiro!

3. **JSON Bruto (API):**
   ```
   https://SEU_APP.onrender.com/view-json.php
   ```
   ⚠️ Precisa fazer login primeiro!

## 📊 Passo 5: Demonstração para o Professor

### Roteiro de Apresentação

1. **Mostrar a página de login:**
   - Acesse: `https://SEU_APP.onrender.com/login.php`
   - Explique: "Este é o formulário de login"

2. **Fazer login com dados de teste:**
   - CPF: `123.456.789-00`
   - Senha: `senha123`
   - Clique em "Entrar"

3. **Mostrar que foi redirecionado para o dashboard:**
   - Explique: "O login foi aceito e os dados foram salvos"

4. **Acessar a página de usuários:**
   - No menu lateral, clique no ícone de banco de dados (último ícone da seção Admin)
   - OU acesse diretamente: `https://SEU_APP.onrender.com/admin-users.php`

5. **Mostrar a tabela de usuários:**
   - Aponte para a tabela com os dados
   - Destaque:
     - ✅ ID do usuário
     - ✅ CPF formatado
     - ✅ Senha criptografada (hash bcrypt)
     - ✅ Data de criação
     - ✅ Último login

6. **Mostrar o JSON bruto:**
   - Clique no botão "Ver JSON Completo"
   - OU acesse: `https://SEU_APP.onrender.com/view-json.php`
   - Mostre o JSON formatado com os dados

7. **Fazer um segundo login:**
   - Faça logout
   - Faça login novamente com CPF diferente: `987.654.321-00`
   - Volte para `admin-users.php`
   - Mostre que agora há 2 usuários na tabela

## 🎯 Pontos a Destacar na Apresentação

### Para o Professor

✅ **"Os dados são salvos automaticamente"**
   - Ao fazer login, o sistema salva CPF e senha no banco

✅ **"Senhas são criptografadas"**
   - Mostre o hash na tabela (começa com `$2y$12$...`)
   - Explique que é impossível recuperar a senha original

✅ **"Banco de dados em JSON"**
   - Arquivo `data/users.json` armazena todos os usuários
   - Funciona como um banco de dados simples

✅ **"Sistema não valida credenciais"**
   - Qualquer CPF/senha é aceito (conforme solicitado)
   - Foco é no armazenamento, não na validação

✅ **"Interface administrativa"**
   - Página `admin-users.php` mostra todos os usuários
   - Não precisa abrir arquivos do projeto

## 📱 URLs para Compartilhar

Envie estas URLs para o professor:

```
🔗 Site Principal:
https://SEU_APP.onrender.com

🔗 Login:
https://SEU_APP.onrender.com/login.php

🔗 Banco de Dados (após login):
https://SEU_APP.onrender.com/admin-users.php

🔗 JSON (após login):
https://SEU_APP.onrender.com/view-json.php
```

## ⚠️ Observações Importantes

### Sobre o Render (Plano Free)

1. **Primeira requisição pode ser lenta:**
   - O Render "hiberna" apps gratuitos após 15 minutos de inatividade
   - Primeira requisição pode levar 30-60 segundos
   - Requisições seguintes são rápidas

2. **Persistência de dados:**
   - No Render Free, o sistema de arquivos é efêmero
   - Dados em `data/users.json` podem ser perdidos após reinicialização
   - Para demonstração acadêmica, isso é aceitável
   - Se quiser persistência real, considere usar banco de dados (PostgreSQL, MySQL)

3. **Solução para persistência (opcional):**
   - Use o GitHub como "backup"
   - Faça commit dos dados após cada teste
   - Ou migre para um banco de dados real

### Para Garantir que Funcione

1. **Teste localmente primeiro:**
   ```bash
   cd central-estagios-main
   php -S localhost:8000
   ```

2. **Verifique permissões do diretório data/:**
   ```bash
   chmod 755 data/
   chmod 644 data/users.json
   ```

3. **Teste todas as URLs antes de apresentar**

## 🐛 Troubleshooting

### Problema: "404 Not Found"

**Solução:** Verifique se o "Root Directory" no Render está configurado como `central-estagios-main`

### Problema: "Erro ao salvar dados"

**Solução:** Verifique permissões do diretório `data/` no servidor

### Problema: "Página em branco"

**Solução:** 
1. Verifique os logs no Render Dashboard
2. Certifique-se de que o PHP está instalado
3. Verifique se todos os arquivos foram enviados para o GitHub

### Problema: "Session não funciona"

**Solução:** Adicione no início do `index.php`:
```php
ini_set('session.save_path', '/tmp');
```

## 📞 Suporte

Se tiver problemas:

1. Verifique os logs no Render Dashboard
2. Teste localmente primeiro
3. Verifique se todos os arquivos estão no GitHub
4. Consulte a documentação do Render: https://render.com/docs

## ✅ Checklist Final

Antes de apresentar, verifique:

- [ ] Projeto está no GitHub
- [ ] Deploy no Render foi bem-sucedido
- [ ] Site está acessível (status "Live")
- [ ] Consegue fazer login
- [ ] Página `admin-users.php` funciona
- [ ] Dados são salvos corretamente
- [ ] JSON é exibido em `view-json.php`
- [ ] Testou com múltiplos usuários

---

**Boa sorte na apresentação! 🎓🚀**