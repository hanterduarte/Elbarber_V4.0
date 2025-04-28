<?php $__env->startSection('title', 'Agendamentos'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item active">Agendamentos</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Agendamentos</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('appointments.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Agendamento
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th>Cliente</th>
                        <th>Barbeiro</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th style="width: 100px">Status</th>
                        <th style="width: 160px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($appointment->id); ?></td>
                            <td><?php echo e($appointment->client ? $appointment->client->name : 'Cliente Removido'); ?></td>
                            <td><?php echo e($appointment->barber && $appointment->barber->user ? $appointment->barber->user->name : 'Barbeiro Removido'); ?></td>
                            <td><?php echo e($appointment->service ? $appointment->service->name : 'Serviço Removido'); ?></td>
                            <td><?php echo e($appointment->start_time->format('d/m/Y')); ?></td>
                            <td><?php echo e($appointment->start_time->format('H:i')); ?></td>
                            <td>
                                <?php if($appointment->status == 'scheduled'): ?>
                                    <span class="badge badge-primary">Agendado</span>
                                <?php elseif($appointment->status == 'confirmed'): ?>
                                    <span class="badge badge-success">Confirmado</span>
                                <?php elseif($appointment->status == 'completed'): ?>
                                    <span class="badge badge-info">Concluído</span>
                                <?php elseif($appointment->status == 'cancelled'): ?>
                                    <span class="badge badge-danger">Cancelado</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('appointments.show', $appointment->id)); ?>" class="btn btn-info btn-sm" title="Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('appointments.edit', $appointment->id)); ?>" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('appointments.destroy', $appointment->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">Nenhum agendamento encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($appointments->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Elbarber_V4.0\resources\views/appointments/index.blade.php ENDPATH**/ ?>