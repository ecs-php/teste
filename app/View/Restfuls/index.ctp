<div class="container">
	<?php echo $this->Flash->render(); ?>
	<div>&nbsp;</div>
	<div class="row">
		<?php echo $this->Form->create('Restful', array('type' => 'get')); ?>
		<div class="col-xs-1">
			<label class="pull-right pt-7">ID:</label>
		</div>
		<div class="col-xs-1">
			<?php echo $this->Form->hidden('method', array('value' => 'list')); ?>
			<?php echo $this->Form->input('id', array('type' => 'text', 'label' => false, 'class' => 'form-control')); ?>
		</div>
		<div class="col-xs-4">
			<?php echo $this->Form->button('Filtrar', array('class' => 'btn btn-default')); ?>
			<?php echo $this->Html->link('Limpar filtro', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
		</div>
		<div class="col-xs-2 pull-right">
			<?php echo $this->Html->link('Novo usuário', array('action' => 'add'), array('class' => 'btn btn-success')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
	<hr>
	<h2>Lista de Usuários</h2>
	<?php if(!empty($users)) { ?>
	<div class="row">
		<div class="col-xs-12">
			<table class="table">
				<thead>
					<tr>
						<th>Código</th>
						<th>Nome</th>
						<th>Sobrenome</th>
						<th>E-mail</th>
						<th>Telefone</th>
						<th>Celular</th>
						<th>Ações</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($users as $key => $user) { ?>
					<tr>
						<td>
							<?php echo $user->User->id; ?>
						</td>
						<td>
							<?php echo $user->User->name; ?>
						</td>
						<td>
							<?php echo $user->User->last_name; ?>
						</td>
						<td>
							<?php echo $user->User->email; ?>
						</td>
						<td>
							<?php echo $user->User->phone; ?>
						</td>
						<td>
							<?php echo $user->User->cellphone; ?>
						</td>
						<td>
							<?php echo $this->Html->link('Editar', array('action' => 'edit', $user->User->id), array('class' => 'btn-xs btn-warning')) ?>
							<?php echo $this->Html->link('Excluir', array('action' => 'delete', $user->User->id), array('class' => 'btn-xs btn-danger'), 'Tem certeza que deseja escluir este registro?') ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php } else { ?>
	<div class="alert alert-warning" role="alert">Não há resultados disponíveis</div>
	<?php } ?>
</div>

<!-- Modal -->
<div class="modal fade" id="viewJson" tabindex="-1" role="dialog" aria-labelledby="viewJsonLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Dados recebidos em Json</h4>
			</div>
			<div class="modal-body">
				<?php echo $json; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>