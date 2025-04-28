<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <!-- Today's Revenue -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>R$ <?php echo e(number_format($todayRevenue, 2, ',', '.')); ?></h3>
                    <p>Receita do Dia</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <!-- Current Cash Register -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Caixa <?php echo e($currentCashRegister ? 'Aberto' : 'Fechado'); ?></h3>
                    <p>
                        <?php if($currentCashRegister): ?>
                            Aberto por: <?php echo e($currentCashRegister->user->name); ?><br>
                            Abertura: <?php echo e($currentCashRegister->opened_at->format('d/m/Y H:i')); ?>

                        <?php else: ?>
                            Nenhum caixa aberto
                        <?php endif; ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-cash-register"></i>
                </div>
            </div>
        </div>

        <!-- Last Closed Register -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Último Caixa</h3>
                    <p>
                        <?php if($lastClosedRegister): ?>
                            Fechado por: <?php echo e($lastClosedRegister->closedByUser->name); ?><br>
                            Total: R$ <?php echo e(number_format($lastClosedRegister->final_amount, 2, ',', '.')); ?>

                        <?php else: ?>
                            Nenhum caixa fechado
                        <?php endif; ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-history"></i>
                </div>
            </div>
        </div>

        <!-- Today's Appointments Count -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?php echo e($todayAppointments->count()); ?></h3>
                    <p>Agendamentos Hoje</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Today's Appointments -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Agendamentos de Hoje</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Horário</th>
                                    <th>Cliente</th>
                                    <th>Barbeiro</th>
                                    <th>Serviço</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $todayAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($appointment->start_time->format('H:i')); ?></td>
                                        <td><?php echo e($appointment->client ? $appointment->client->name : 'Cliente Removido'); ?></td>
                                        <td><?php echo e($appointment->barber && $appointment->barber->user ? $appointment->barber->user->name : 'Barbeiro Removido'); ?></td>
                                        <td><?php echo e($appointment->service ? $appointment->service->name : 'Serviço Removido'); ?></td>
                                        <td>
                                            <?php switch($appointment->status):
                                                case ('scheduled'): ?>
                                                    <span class="badge badge-info">Agendado</span>
                                                    <?php break; ?>
                                                <?php case ('confirmed'): ?>
                                                    <span class="badge badge-primary">Confirmado</span>
                                                    <?php break; ?>
                                                <?php case ('completed'): ?>
                                                    <span class="badge badge-success">Concluído</span>
                                                    <?php break; ?>
                                                <?php case ('cancelled'): ?>
                                                    <span class="badge badge-danger">Cancelado</span>
                                                    <?php break; ?>
                                            <?php endswitch; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum agendamento para hoje</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Próximos Agendamentos</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Cliente</th>
                                    <th>Barbeiro</th>
                                    <th>Serviço</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($appointment->start_time->format('d/m/Y H:i')); ?></td>
                                        <td><?php echo e($appointment->client ? $appointment->client->name : 'Cliente Removido'); ?></td>
                                        <td><?php echo e($appointment->barber && $appointment->barber->user ? $appointment->barber->user->name : 'Barbeiro Removido'); ?></td>
                                        <td><?php echo e($appointment->service ? $appointment->service->name : 'Serviço Removido'); ?></td>
                                        <td>
                                            <?php switch($appointment->status):
                                                case ('scheduled'): ?>
                                                    <span class="badge badge-info">Agendado</span>
                                                    <?php break; ?>
                                                <?php case ('confirmed'): ?>
                                                    <span class="badge badge-primary">Confirmado</span>
                                                    <?php break; ?>
                                                <?php case ('completed'): ?>
                                                    <span class="badge badge-success">Concluído</span>
                                                    <?php break; ?>
                                                <?php case ('cancelled'): ?>
                                                    <span class="badge badge-danger">Cancelado</span>
                                                    <?php break; ?>
                                            <?php endswitch; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum agendamento futuro</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Elbarber_V4.0\resources\views/dashboard.blade.php ENDPATH**/ ?>