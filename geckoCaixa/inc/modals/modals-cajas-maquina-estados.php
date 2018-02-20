<!-- Cada modal aparecerá acorde al color de fondo de la máquina.-->


<?php $titleIdModal = 'modal-cajas-maquina-estado'; ?>
<!-- .thumbnail1
  background-color: #337ab7-->



<div id="<?php echo $titleIdModal."1"; ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5>Maquina</h5>
      </div>
      <div class="modal-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel, repellendus eos dolore voluptatem reprehenderit, doloremque quibusdam mollitia quo voluptatum est totam. Aliquam, eum. Sunt molestiae placeat porro autem, nemo temporibus.</p>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <tbody>
              <tr>
                <td>Máquina</td>
                <td><?php echo rand(0,99999)?></td>
              </tr>
              <tr>
                <td>Crédito</td>
                <td><?php echo rand(0,99999)?></td>
              </tr>
              <tr>
                <td>Valor</td>
                <td><?php echo rand(0,99999)?></td>
              </tr>
              <tr>
                <td>Operador</td>
                <td><?php echo rand(0,99999)?></td>
              </tr>
            </tbody>
          </table>
          <div class="row">
            <div class="col-xs-12">
              <a href="#" class="btn">Nueva</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- .thumbnail2 -->
<div id="<?php echo $titleIdModal."2"; ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
        <h5><?php echo date('d/m/Y');?></h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>
                  <?php echo _('Maquina') ?>
                </th>
                <th>
                  <?php echo _('Orden') ?>
                </th>
                <th>
                  <?php echo _('Editar') ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i < 3 ; $i++):?>
                <tr>
                  <td><?php echo('vmtd -'.rand(100,2000)); ?></td>
                  <td><?php echo rand(1,9)?></td>
                  <td>
                    <div class="input-group">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-minus"></span>
                        </button>
                      </span>
                      <!-- <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100"> -->
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-plus"></span>
                        </button>
                      </span>
                    </div>
                  </td>
                </tr>
              <?php endfor; ?>
            </tbody>
          </table>
          <a href="#" class="btn"><?php echo _('Reordenar') ?></a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- .thumbnail3 -->
<div id="<?php echo $titleIdModal."3"; ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
        <h5><?php echo date('d/m/Y');?></h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>
                  <?php echo _('Maquina') ?>
                </th>
                <th>
                  <?php echo _('Orden') ?>
                </th>
                <th>
                  <?php echo _('Editar') ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i < 3 ; $i++):?>
                <tr>
                  <td><?php echo('vmtd -'.rand(100,2000)); ?></td>
                  <td><?php echo rand(1,9)?></td>
                  <td>
                    <div class="input-group">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-minus"></span>
                        </button>
                      </span>
                      <!-- <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100"> -->
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-plus"></span>
                        </button>
                      </span>
                    </div>
                  </td>
                </tr>
              <?php endfor; ?>
            </tbody>
          </table>
          <a href="#" class="btn"><?php echo _('Reordenar') ?></a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- .thumbnail4 -->
<div id="<?php echo $titleIdModal."4"; ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
        <h5><?php echo date('d/m/Y');?></h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>
                  <?php echo _('Maquina') ?>
                </th>
                <th>
                  <?php echo _('Orden') ?>
                </th>
                <th>
                  <?php echo _('Editar') ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i < 3 ; $i++):?>
                <tr>
                  <td><?php echo('vmtd -'.rand(100,2000)); ?></td>
                  <td><?php echo rand(1,9)?></td>
                  <td>
                    <div class="input-group">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-minus"></span>
                        </button>
                      </span>
                      <!-- <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100"> -->
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-plus"></span>
                        </button>
                      </span>
                    </div>
                  </td>
                </tr>
              <?php endfor; ?>
            </tbody>
          </table>
          <a href="#" class="btn"><?php echo _('Reordenar') ?></a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- .thumbnail5 -->
<div id="<?php echo $titleIdModal."5"; ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
        <h5><?php echo date('d/m/Y');?></h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>
                  <?php echo _('Maquina') ?>
                </th>
                <th>
                  <?php echo _('Orden') ?>
                </th>
                <th>
                  <?php echo _('Editar') ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i < 3 ; $i++):?>
                <tr>
                  <td><?php echo('vmtd -'.rand(100,2000)); ?></td>
                  <td><?php echo rand(1,9)?></td>
                  <td>
                    <div class="input-group">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-minus"></span>
                        </button>
                      </span>
                      <!-- <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100"> -->
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-plus"></span>
                        </button>
                      </span>
                    </div>
                  </td>
                </tr>
              <?php endfor; ?>
            </tbody>
          </table>
          <a href="#" class="btn"><?php echo _('Reordenar') ?></a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- .thumbnail6 -->
<div id="<?php echo $titleIdModal."6"; ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
        <h5><?php echo date('d/m/Y');?></h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>
                  <?php echo _('Maquina') ?>
                </th>
                <th>
                  <?php echo _('Orden') ?>
                </th>
                <th>
                  <?php echo _('Editar') ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i < 3 ; $i++):?>
                <tr>
                  <td><?php echo('vmtd -'.rand(100,2000)); ?></td>
                  <td><?php echo rand(1,9)?></td>
                  <td>
                    <div class="input-group">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-minus"></span>
                        </button>
                      </span>
                      <!-- <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100"> -->
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-plus"></span>
                        </button>
                      </span>
                    </div>
                  </td>
                </tr>
              <?php endfor; ?>
            </tbody>
          </table>
          <a href="#" class="btn"><?php echo _('Reordenar') ?></a>
        </div>
      </div>
    </div>
  </div>
</div>