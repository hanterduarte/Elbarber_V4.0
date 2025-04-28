<?php $__env->startSection('title', 'Detalhes do Barbeiro'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('barbers.index')); ?>">Barbeiros</a></li>
<li class="breadcrumb-item active">Detalhes</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Barbeiro</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('barbers.edit', $barber->id)); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="<?php echo e(route('barbers.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <img src="<?php echo e($barber->photo ? asset('storage/' . $barber->photo) : asset('images/default-avatar.png')); ?>" 
                     class="img-fluid rounded" 
                     alt="Foto do barbeiro"
                     style="max-height: 200px; width: auto;">
            </div>
            <div class="col-md-9">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">ID</th>
                        <td><?php echo e($barber->id); ?></td>
                    </tr>
                    <tr>
                        <th>Nome</th>
                        <td><?php echo e($barber->user->name); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo e($barber->user->email); ?></td>
                    </tr>
                    <tr>
                        <th>Telefone</th>
                        <td><?php echo e($barber->phone); ?></td>
                    </tr>
                    <tr>
                        <th>Especialidades</th>
                        <td><?php echo e($barber->specialties ?? 'Não informadas'); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if($barber->is_active): ?>
                                <span class="badge badge-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inativo</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Data de Criação</th>
                        <td><?php echo e($barber->created_at->format('d/m/Y H:i:s')); ?></td>
                    </tr>
                    <tr>
                        <th>Última Atualização</th>
                        <td><?php echo e($barber->updated_at->format('d/m/Y H:i:s')); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <form action="<?php echo e(route('barbers.destroy', $barber->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este barbeiro?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>

<?php if($barber->appointments->count() > 0): ?>
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Agendamentos</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Status</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $barber->appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($appointment->id); ?></td>
                            <td><?php echo e($appointment->client->name); ?></td>
                            <td><?php echo e($appointment->service->name); ?></td>
                            <td><?php echo e($appointment->date ? $appointment->date->format('d/m/Y') : 'N/A'); ?></td>
                            <td><?php echo e($appointment->time ? $appointment->time->format('H:i') : 'N/A'); ?></td>
                            <td>
                                <?php switch($appointment->status):
                                    case ('scheduled'): ?>
                                        <span class="badge badge-info">Agendado</span>
                                        <?php break; ?>
                                    <?php case ('confirmed'): ?>
                                        <span class="badge badge-success">Confirmado</span>
                                        <?php break; ?>
                                    <?php case ('completed'): ?>
                                        <span class="badge badge-primary">Concluído</span>
                                        <?php break; ?>
                                    <?php case ('cancelled'): ?>
                                        <span class="badge badge-danger">Cancelado</span>
                                        <?php break; ?>
                                    <?php default: ?>
                                        <span class="badge badge-secondary"><?php echo e($appointment->status); ?></span>
                                <?php endswitch; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('appointments.show', $appointment)); ?>" class="btn btn-info btn-sm" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('appointments.edit', $appointment)); ?>" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Elbarber_V4.0\resources\views/barbers/show.blade.php ENDPATH**/ ?>