<?php
require_once 'includes/config.php';
checkAuth();

$pageTitle = 'Banco de Dados - Usuários';

// Carregar usuários do banco de dados
$usersData = loadData('users');
$users = $usersData['users'] ?? [];

include 'includes/header.php';
?>

<main class="ml-16 pt-16">
    <div class="p-8 max-w-7xl mx-auto">
        
        <!-- Cabeçalho -->
        <div class="bg-gradient-to-r from-[#4A9FCA] to-[#2B7FA6] text-white p-8 rounded-[24px] mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">🗄️ Banco de Dados</h1>
                    <p class="text-white/90">Usuários cadastrados no sistema</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-6 py-4 rounded-2xl">
                    <div class="text-4xl font-bold"><?php echo count($users); ?></div>
                    <div class="text-sm text-white/80">Total de Usuários</div>
                </div>
            </div>
        </div>

        <?php if (empty($users)): ?>
            <!-- Mensagem quando não há usuários -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Nenhum usuário cadastrado ainda</h3>
                <p class="text-gray-500">Faça login pela primeira vez para registrar um usuário no banco de dados.</p>
            </div>
        <?php else: ?>
            <!-- Tabela Simplificada de Usuários -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800">📋 Credenciais Salvas no Banco</h2>
                    <p class="text-sm text-gray-500 mt-1">CPF e Senha de todos os usuários que fizeram login</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b-2 border-gray-300">
                            <tr>
                                <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    CPF
                                </th>
                                <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    Senha (Criptografada)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($users as $index => $user): ?>
                                <tr class="hover:bg-blue-50 transition-colors <?php echo $index % 2 == 0 ? 'bg-white' : 'bg-gray-50'; ?>">
                                    <!-- CPF -->
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-[#4A9FCA] rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-id-card text-white text-lg"></i>
                                            </div>
                                            <div>
                                                <div class="font-mono text-lg font-semibold text-gray-900">
                                                    <?php 
                                                        $cpf = $user['cpf'];
                                                        echo substr($cpf, 0, 3) . '.' . 
                                                             substr($cpf, 3, 3) . '.' . 
                                                             substr($cpf, 6, 3) . '-' . 
                                                             substr($cpf, 9, 2);
                                                    ?>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <i class="fas fa-calendar text-gray-400"></i>
                                                    Cadastrado em <?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Senha Criptografada -->
                                    <td class="px-8 py-5">
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-lock text-green-600 text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <code class="block text-sm bg-green-50 text-green-800 px-4 py-2 rounded-lg font-mono break-all border border-green-200">
                                                    <?php echo htmlspecialchars($user['password_hash']); ?>
                                                </code>
                                                <div class="flex items-center gap-2 mt-2 text-xs text-gray-600">
                                                    <i class="fas fa-shield-alt text-green-600"></i>
                                                    <span>Criptografado com <strong>Bcrypt</strong> (irreversível)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Informações Técnicas -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card 1: Sobre o Banco -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-database text-[#4A9FCA] text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-3 text-lg">📊 Sobre o Banco de Dados</h3>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                    <span><strong>Tipo:</strong> Arquivo JSON</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                    <span><strong>Localização:</strong> <code class="bg-white px-2 py-0.5 rounded">data/users.json</code></span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                    <span><strong>Total de registros:</strong> <?php echo count($users); ?> usuário(s)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Sobre a Segurança -->
                <div class="bg-green-50 border-2 border-green-200 rounded-2xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-3 text-lg">🔒 Segurança</h3>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                    <span><strong>Algoritmo:</strong> Bcrypt (custo 12)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                    <span><strong>Hash:</strong> Irreversível (não dá para descobrir a senha)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                    <span><strong>Salt:</strong> Automático e único para cada senha</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="view-json.php" target="_blank" class="inline-flex items-center gap-2 bg-gray-800 text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-700 transition-all shadow-lg">
                    <i class="fas fa-code"></i>
                    Ver JSON Completo
                </a>
                <a href="dashboard.php" class="inline-flex items-center gap-2 bg-[#4A9FCA] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#3A8FB0] transition-all shadow-lg">
                    <i class="fas fa-home"></i>
                    Voltar ao Dashboard
                </a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include 'includes/footer.php'; ?>
