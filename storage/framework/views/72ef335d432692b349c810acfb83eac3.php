<?php $__env->startSection('title', 'Detalhes do Cliente'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('clients.index')); ?>">Clientes</a></li>
<li class="breadcrumb-item active">Detalhes</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Cliente</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('clients.edit', $client->id)); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">ID</th>
                        <td><?php echo e($client->id); ?></td>
                    </tr>
                    <tr>
                        <th>Nome</th>
                        <td><?php echo e($client->name); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo e($client->email ?? 'Não informado'); ?></td>
                    </tr>
                    <tr>
                        <th>Telefone</th>
                        <td><?php echo e($client->phone); ?></td>
                    </tr>
                    <tr>
                        <th>Data de Nascimento</th>
                        <td><?php echo e($client->birth_date ? date('d/m/Y', strtotime($client->birth_date)) : 'Não informada'); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if($client->is_active): ?>
                                <span class="badge badge-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inativo</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Data de Criação</th>
                        <td><?php echo e($client->created_at->format('d/m/Y H:i:s')); ?></td>
                    </tr>
                    <tr>
                        <th>Última Atualização</th>
                        <td><?php echo e($client->updated_at->format('d/m/Y H:i:s')); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">CEP</th>
                        <td><?php echo e($client->zip_code ?? 'Não informado'); ?></td>
                    </tr>
                    <tr>
                        <th>Endereço</th>
                        <td><?php echo e($client->street ?? 'Não informado'); ?></td>
                    </tr>
                    <tr>
                        <th>Número</th>
                        <td><?php echo e($client->number ?? 'Não informado'); ?></td>
                    </tr>
                    <tr>
                        <th>Complemento</th>
                        <td><?php echo e($client->complement ?? 'Não informado'); ?></td>
                    </tr>
                    <tr>
                        <th>Bairro</th>
                        <td><?php echo e($client->district ?? 'Não informado'); ?></td>
                    </tr>
                    <tr>
                        <th>Cidade</th>
                        <td><?php echo e($client->city ?? 'Não informado'); ?></td>
                    </tr>
                    <tr>
                        <th>Ponto de Referência</th>
                        <td><?php echo e($client->reference_point ?? 'Não informado'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <form action="<?php echo e(route('clients.destroy', $client->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Elbarber_V4.0\resources\views/clients/show.blade.php ENDPATH**/ ?>