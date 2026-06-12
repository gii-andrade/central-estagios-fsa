<?php
/**
 * Funções de Autenticação
 * Gerencia salvamento e autenticação de usuários no banco de dados JSON
 */

require_once __DIR__ . '/config.php';

/**
 * Salva um novo usuário no banco de dados JSON
 * @param string $cpf CPF do usuário
 * @param string $password Senha em texto plano
 * @return bool True se salvou com sucesso
 */
function saveUser($cpf, $password) {
    // Formatar CPF (remover caracteres especiais)
    $cpfFormatted = formatCpf($cpf);
    
    // Carregar usuários existentes
    $data = loadData('users');
    if (!$data) {
        $data = ['users' => []];
    }
    
    // Verificar se usuário já existe
    $existingUser = getUserByCpf($cpfFormatted);
    
    if ($existingUser) {
        // Usuário já existe, apenas atualizar último login
        updateLastLogin($cpfFormatted);
        return true;
    }
    
    // Criar novo usuário
    $newUser = [
        'id' => generateUserId(),
        'cpf' => $cpfFormatted,
        'password_hash' => hashPassword($password),
        'name' => $_SESSION['user_name'] ?? 'Usuário',
        'created_at' => date('Y-m-d H:i:s'),
        'last_login' => date('Y-m-d H:i:s')
    ];
    
    // Adicionar usuário ao array
    $data['users'][] = $newUser;
    
    // Salvar no arquivo JSON
    saveData('users', $data);
    
    return true;
}

/**
 * Criptografa a senha usando bcrypt
 * @param string $password Senha em texto plano
 * @return string Hash da senha
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Busca um usuário pelo CPF
 * @param string $cpf CPF formatado (apenas números)
 * @return array|null Dados do usuário ou null se não encontrado
 */
function getUserByCpf($cpf) {
    $data = loadData('users');
    
    if (!$data || !isset($data['users'])) {
        return null;
    }
    
    foreach ($data['users'] as $user) {
        if ($user['cpf'] === $cpf) {
            return $user;
        }
    }
    
    return null;
}

/**
 * Atualiza o último login do usuário
 * @param string $cpf CPF formatado (apenas números)
 * @return bool True se atualizou com sucesso
 */
function updateLastLogin($cpf) {
    $data = loadData('users');
    
    if (!$data || !isset($data['users'])) {
        return false;
    }
    
    // Encontrar e atualizar usuário
    foreach ($data['users'] as $key => $user) {
        if ($user['cpf'] === $cpf) {
            $data['users'][$key]['last_login'] = date('Y-m-d H:i:s');
            saveData('users', $data);
            return true;
        }
    }
    
    return false;
}

/**
 * Formata o CPF removendo caracteres especiais
 * @param string $cpf CPF com ou sem formatação
 * @return string CPF apenas com números
 */
function formatCpf($cpf) {
    return preg_replace('/[^0-9]/', '', $cpf);
}

/**
 * Gera o próximo ID disponível para usuário
 * @return int Próximo ID
 */
function generateUserId() {
    $data = loadData('users');
    
    if (!$data || !isset($data['users']) || empty($data['users'])) {
        return 1;
    }
    
    $lastUser = end($data['users']);
    return $lastUser['id'] + 1;
}
?>
