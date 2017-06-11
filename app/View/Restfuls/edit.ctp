<div class="container">
	<div>&nbsp;</div>
	<h2>Editar usuário</h2>
	<?php echo $this->Form->create('Restful', array('type' => 'get', 'inputDefaults' => array('class' => 'form-control'))) ?>
	<?php echo $this->Form->hidden('id') ?>
	<div class="row">
		<div class="col-xs-12">
			<div class="form-group">
				<div class="row">
					<div class="col-xs-6">
						<?php echo $this->Form->input('name', array('label' => 'Nome')); ?>	
					</div>
					<div class="col-xs-6">
						<?php echo $this->Form->input('last_name', array('label' => 'Sobrenome')); ?>	
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-6">
						<?php echo $this->Form->input('email', array('label' => 'E-mail')); ?>	
					</div>
					<div class="col-xs-3">
						<?php echo $this->Form->input('phone', array('label' => 'Telefone')); ?>	
					</div>
					<div class="col-xs-3">
						<?php echo $this->Form->input('cellphone', array('label' => 'Celular')); ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12">
			<div class="form-group">
				<div class="row">
					<div class="col-xs-6">
						<?php echo $this->Form->input('address', array('label' => 'Endereço')); ?>	
					</div>
					<div class="col-xs-2">
						<?php echo $this->Form->input('number', array('label' => 'Número')); ?>	
					</div>
					<div class="col-xs-4">
						<?php echo $this->Form->input('complement', array('label' => 'Complemento')); ?>	
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-6">
						<?php echo $this->Form->input('neighborhood', array('label' => 'Bairro')); ?>	
					</div>
					<div class="col-xs-4">
						<?php echo $this->Form->input('city', array('label' => 'Cidade')); ?>	
					</div>
					<div class="col-xs-2">
						<?php echo $this->Form->input('province', array('label' => 'Estado')); ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Form->button('Salvar', array('class' => 'btn btn-success')); ?>
			<?php echo $this->Html->link('Voltar', array('action' => 'index'), array('class' => 'btn btn-danger')) ?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
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
				<?php
				if(!empty($json)) {	
					echo $json;
				}
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>