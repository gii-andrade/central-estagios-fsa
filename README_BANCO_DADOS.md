# 🔐 Sistema de Banco de Dados Fictício - Central de Estágios

## 📋 Visão Geral

Este sistema implementa um banco de dados fictício usando arquivos JSON para armazenar credenciais de login (CPF e senha) dos usuários que acessam a Central de Estágios.

## ✨ Características

- ✅ **Armazenamento em JSON**: Usa arquivo `data/users.json` como banco de dados
- ✅ **Senhas Criptografadas**: Utiliza bcrypt (algoritmo seguro) para hash de senhas
- ✅ **Sem Validação**: Sistema aceita qualquer CPF/senha (conforme solicitado)
- ✅ **Registro Automático**: Salva automaticamente ao fazer login
- ✅ **Prevenção de Duplicatas**: Não duplica usuários com mesmo CPF
- ✅ **Rastreamento**: Registra data de criação e último login

## 🏗️ Arquitetura

### Arquivos Criados

```
central-estagios-main/
├── data/
│   └── users.json              # Banco de dados de usuários
├── includes/
│   └── auth.php                # Funções de autenticação
├── test_login.php              # Script de teste (opcional)
└── README_BANCO_DADOS.md       # Esta documentação
```

### Arquivos Modificados

```
central-estagios-main/
├── index.php                   # Adicionado salvamento de usuário
└── login.php                   # Adicionado atributos name nos campos
```

## 📊 Estrutura do Banco de Dados

### Arquivo: `data/users.json`

```json
{
  "users": [
    {
      "id": 1,
      "cpf": "12345678900",
      "password_hash": "$2y$12$...",
      "name": "Lavínia Carrasco",
      "created_at": "2026-06-12 13:22:00",
      "last_login": "2026-06-12 13:22:00"
    }
  ]
}
```

### Campos Explicados

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | Integer | ID único incremental do usuário |
| `cpf` | String | CPF sem formatação (apenas números) |
| `password_hash` | String | Hash bcrypt da senha (irreversível) |
| `name` | String | Nome do usuário (padrão: "Lavínia Carrasco") |
| `created_at` | DateTime | Data/hora de criação do registro |
| `last_login` | DateTime | Data/hora do último acesso |

## 🚀 Como Usar

### 1. Iniciar o Servidor

```bash
cd central-estagios-main
php -S localhost:8000
```

### 2. Acessar o Sistema

Abra o navegador e acesse:
- **Página de Login**: http://localhost:8000/login.php
- **Página Principal**: http://localhost:8000/index.php

### 3. Fazer Login

1. Digite qualquer CPF (ex: 123.456.789-00)
2. Digite qualquer senha (ex: minhasenha123)
3. Clique em "Entrar"
4. O sistema irá:
   - Salvar o CPF e senha (criptografada) no `users.json`
   - Criar uma sessão
   - Redirecionar para o dashboard

### 4. Verificar Dados Salvos

Abra o arquivo `data/users.json` para ver os usuários registrados:

```bash
cat central-estagios-main/data/users.json
```

## 🧪 Testar o Sistema

Execute o script de teste incluído:

```bash
cd central-estagios-main
php test_login.php
```

Este script irá:
- ✅ Criar um usuário de teste
- ✅ Tentar criar o mesmo usuário novamente (deve atualizar last_login)
- ✅ Criar um segundo usuário
- ✅ Exibir o conteúdo do banco de dados

## 🔒 Segurança

### Criptografia de Senha

As senhas são criptografadas usando **bcrypt** com custo 12:

```php
$hash = password_hash($password, PASSWORD_BCRYPT);
// Resultado: $2y$12$RZ6zFt9vytQOYCnfc4cIuO...
```

**Características do bcrypt:**
- ✅ Algoritmo de hash lento (dificulta ataques de força bruta)
- ✅ Salt automático (cada hash é único)
- ✅ Irreversível (impossível recuperar senha original)
- ✅ Padrão da indústria para armazenamento de senhas

### Exemplo de Hash

```
Senha: "senha123"
Hash:  "$2y$12$RZ6zFt9vytQOYCnfc4cIuOfZpyF8HQum8Sx3mRgJeiKK95MzKNfz2"
```

Mesmo que alguém acesse o arquivo `users.json`, **não conseguirá descobrir a senha original**.

## 📝 Funções Disponíveis

### Em `includes/auth.php`

```php
// Salvar novo usuário ou atualizar último login
saveUser($cpf, $password);

// Criptografar senha
$hash = hashPassword($password);

// Buscar usuário por CPF
$user = getUserByCpf($cpf);

// Atualizar último login
updateLastLogin($cpf);

// Formatar CPF (remover caracteres especiais)
$cpfLimpo = formatCpf($cpf);

// Gerar próximo ID disponível
$nextId = generateUserId();
```

## 🔄 Fluxo de Login

```
1. Usuário acessa login.php
   ↓
2. Preenche CPF e senha
   ↓
3. Submete formulário para index.php
   ↓
4. index.php chama saveUser($cpf, $password)
   ↓
5. auth.php verifica se usuário já existe
   ↓
6a. Se NÃO existe: Cria novo registro
6b. Se existe: Atualiza last_login
   ↓
7. Salva no users.json
   ↓
8. Cria sessão do usuário
   ↓
9. Redireciona para dashboard.php
```

## 📂 Exemplo de Uso Real

### Primeiro Login

**Input:**
- CPF: 123.456.789-00
- Senha: minhaSenha123

**Resultado em `users.json`:**
```json
{
  "users": [
    {
      "id": 1,
      "cpf": "12345678900",
      "password_hash": "$2y$12$abc123...",
      "name": "Lavínia Carrasco",
      "created_at": "2026-06-12 14:30:00",
      "last_login": "2026-06-12 14:30:00"
    }
  ]
}
```

### Segundo Login (mesmo usuário)

**Input:**
- CPF: 123.456.789-00
- Senha: outraSenha456

**Resultado em `users.json`:**
```json
{
  "users": [
    {
      "id": 1,
      "cpf": "12345678900",
      "password_hash": "$2y$12$abc123...",
      "name": "Lavínia Carrasco",
      "created_at": "2026-06-12 14:30:00",
      "last_login": "2026-06-12 15:45:00"  ← Atualizado!
    }
  ]
}
```

**Observação:** O usuário não é duplicado, apenas o `last_login` é atualizado.

## ⚠️ Observações Importantes

1. **Sem Validação**: O sistema aceita qualquer CPF/senha (conforme solicitado)
2. **Código Preservado**: Nenhum código existente foi modificado, apenas adicionadas funcionalidades
3. **Banco Fictício**: Usa JSON, não requer instalação de banco de dados real
4. **Produção**: Para ambiente de produção, considere usar banco de dados real (MySQL, PostgreSQL)

## 🛠️ Manutenção

### Limpar Banco de Dados

Para resetar o banco de dados, substitua o conteúdo de `users.json` por:

```json
{
  "users": []
}
```

### Backup

Para fazer backup dos usuários:

```bash
cp central-estagios-main/data/users.json central-estagios-main/data/users_backup.json
```

## 📞 Suporte

Se tiver dúvidas ou problemas:

1. Verifique se o servidor PHP está rodando
2. Verifique permissões do diretório `data/`
3. Consulte o arquivo `test_login.php` para exemplos
4. Revise o arquivo `PLANO_BANCO_DADOS.md` para detalhes técnicos

## ✅ Checklist de Verificação

- [x] Arquivo `data/users.json` existe
- [x] Arquivo `includes/auth.php` existe
- [x] Campos do formulário têm atributos `name`
- [x] `index.php` inclui `auth.php`
- [x] `index.php` chama `saveUser()`
- [x] Senhas são criptografadas com bcrypt
- [x] Sistema não duplica usuários
- [x] `last_login` é atualizado corretamente

---

**Sistema implementado com sucesso! 🎉**

Desenvolvido seguindo as especificações:
- ✅ Banco de dados fictício (JSON)
- ✅ Salva login e senha
- ✅ Senhas criptografadas
- ✅ Sem validação de credenciais
- ✅ Código existente preservado