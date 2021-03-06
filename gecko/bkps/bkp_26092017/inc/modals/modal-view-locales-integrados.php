<?php $modal_item = "Locales-integrados" // ingresar la palabra clave de cada modal ?>
<div id="view-modal-locales-integrados" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
      
      
        <div id="loadingInfo" align="center" style="display:none;">
        	<img src="img/load.gif" />
        </div>         
                        <!-- Información máquina -->
                        <div id="conteudoOnline" class="panel">
                          <div class="panel-heading">
                            <?php echo _('Información máquina:') ?>
                            &nbsp; &nbsp;
                            <strong><span id="maqSelecionada" title="0">&nbsp;</span></strong>
                          </div>
                          <div class="panel-body">
                            <div class="info-maquina" style="display:none;">
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a class="btn btn-raised" href="#info" aria-controls="info" role="tab" data-toggle="tab">Información</a></li>
                                <li role="presentation"><a class="btn btn-raised" href="#stats" aria-controls="last_pay" role="tab" data-toggle="tab">Estadísticas</a></li>
                                <li role="presentation"><a class="btn btn-raised" href="#money" aria-controls="settings" role="tab" data-toggle="tab">Últimos Billetes</a></li>
                                <li role="presentation"><a class="btn btn-raised" href="#last_pay" aria-controls="money" role="tab" data-toggle="tab">Últimos Pagos</a></li>
                                <li role="presentation"><a class="btn btn-raised" href="#games" aria-controls="games" role="tab" data-toggle="tab">Últimas Jugadas</a></li>
                                <li role="presentation"><a class="btn btn-raised" href="#last_prizes" aria-controls="prizes" role="tab" data-toggle="tab">Últimos Premios</a></li>
								<!--- <li role="presentation"><a class="btn btn-raised" href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Configuración</a></li> --->                                
                              </ul>

                              <!-- Tab panes -->
                              <div class="tab-content">
                                <!-- Tab Configuración Maquina -->
                                <div role="tabpanel" class="tab-pane active" id="info">
                                  <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                      <h6>Información</h6>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-xs-8 col-md-8">
                                      <table id="tabelaInfoAtual" class="table table-striped table-hover">
                                        <tbody>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>                                          
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>  
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>                                             
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>                                                                                 
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>                                           
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>

                                <!-- Tab Ultimos pagos -->
                                <div role="tabpanel" class="tab-pane" id="last_pay">
                                  <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                      <h6>Últimos pagos</h6>
                                      <div class="table-responsive">
                                            <table id="tabelaUltimosPagos" class="table table-striped table-hover locales">
                                                <thead>
                                                    <tr data-local="01">
                                                        <th><?php echo _('Pagos $') ?></th>
                                                        <th><?php echo _('Fecha') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr data-local="02">
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                
                                
                                <!-- Tab Ultimos premios -->
                                <div role="tabpanel" class="tab-pane" id="last_prizes">
                                  <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                      <h6>Últimos Premios</h6>
                                      <div class="table-responsive">
                                            <table id="tabelaUltimosPremios" class="table table-striped table-hover locales">
                                                <thead>
                                                    <tr data-local="01">
                                                        <th><?php echo _('Pagos $') ?></th>
                                                        <th><?php echo _('Fecha Máquina') ?></th>
                                                        <th><?php echo _('Fecha Server') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr data-local="02">
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                  </div>
                                </div>                                
                                

                                <!-- Tab Configuraciones -->
                                <div role="tabpanel" class="tab-pane" id="settings">
                                  <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                      <h6>Configuraciones</h6>
                                    </div>
                                  </div>
                                  
                                  <form class="form-horizontal">
                                  <div id="divConfig" class="row">
                                    <div class="col-xs-12 col-md-12">
                                      <table class="table table-striped table-hover">
                                        <tbody>
                                          <tr>
                                            <td>Tipo Moneda: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_tipoMoeda" name="input_tipoMoeda" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="tipoMoeda_eur" name="tipoMoeda_eur" class="mass-act" onClick="atribuiValor(this);"><?php echo _('EUR') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="tipoMoeda_eur" name="tipoMoeda_eur" class="mass-act" onClick="atribuiValor(this);"><?php echo _('USD') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                              
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Denominacion: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_denom" name="input_denom" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="denom_10" name="denom_10" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.010') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_20" name="denom_20" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.020') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_50" name="denom_50" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.050') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_100" name="denom_100" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.100') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_250" name="denom_250" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.250') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_750" name="denom_750" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.750') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_1000" name="denom_1000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('1.000') ?></a>
                                                  </li>                                                 
                                                </ul>
                                              </div>  
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Porcentaje: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_pct" name="input_pct" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="pct_8400" name="pct_8400" class="mass-act" onClick="atribuiValor(this);"><?php echo _('84.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8450" name="pct_8450" class="mass-act" onClick="atribuiValor(this);"><?php echo _('84.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8500" name="pct_8500" class="mass-act" onClick="atribuiValor(this);"><?php echo _('85.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8550" name="pct_8550" class="mass-act" onClick="atribuiValor(this);"><?php echo _('85.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8600" name="pct_8600" class="mass-act" onClick="atribuiValor(this);"><?php echo _('86.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8650" name="pct_8650" class="mass-act" onClick="atribuiValor(this);"><?php echo _('86.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8700" name="pct_8700" class="mass-act" onClick="atribuiValor(this);"><?php echo _('87.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8750" name="pct_8750" class="mass-act" onClick="atribuiValor(this);"><?php echo _('87.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8800" name="pct_8800" class="mass-act" onClick="atribuiValor(this);"><?php echo _('88.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8850" name="pct_8850" class="mass-act" onClick="atribuiValor(this);"><?php echo _('88.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8900" name="pct_8900" class="mass-act" onClick="atribuiValor(this);"><?php echo _('89.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8950" name="pct_8950" class="mass-act" onClick="atribuiValor(this);"><?php echo _('89.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9000" name="pct_9000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('90.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9050" name="pct_9050" class="mass-act" onClick="atribuiValor(this);"><?php echo _('90.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9100" name="pct_9100" class="mass-act" onClick="atribuiValor(this);"><?php echo _('91.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9150" name="pct_9150" class="mass-act" onClick="atribuiValor(this);"><?php echo _('91.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9200" name="pct_9200" class="mass-act" onClick="atribuiValor(this);"><?php echo _('92.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9250" name="pct_9250" class="mass-act" onClick="atribuiValor(this);"><?php echo _('92.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9300" name="pct_9300" class="mass-act" onClick="atribuiValor(this);"><?php echo _('93.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9350" name="pct_9350" class="mass-act" onClick="atribuiValor(this);"><?php echo _('93.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9400" name="pct_9400" class="mass-act" onClick="atribuiValor(this);"><?php echo _('94.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9450" name="pct_9450" class="mass-act" onClick="atribuiValor(this);"><?php echo _('94.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9500" name="pct_9500" class="mass-act" onClick="atribuiValor(this);"><?php echo _('95.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9550" name="pct_9550" class="mass-act" onClick="atribuiValor(this);"><?php echo _('95.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9600" name="pct_9600" class="mass-act" onClick="atribuiValor(this);"><?php echo _('96.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9650" name="pct_9650" class="mass-act" onClick="atribuiValor(this);"><?php echo _('96.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9700" name="pct_9700" class="mass-act" onClick="atribuiValor(this);"><?php echo _('97.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9750" name="pct_9750" class="mass-act" onClick="atribuiValor(this);"><?php echo _('97.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9800" name="pct_9800" class="mass-act" onClick="atribuiValor(this);"><?php echo _('98.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9850" name="pct_9850" class="mass-act" onClick="atribuiValor(this);"><?php echo _('98.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9900" name="pct_9900" class="mass-act" onClick="atribuiValor(this);"><?php echo _('99.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9950" name="pct_9950" class="mass-act" onClick="atribuiValor(this);"><?php echo _('99.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_10000" name="pct_10000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('100.000 %') ?></a>
                                                  </li>                                                                                      
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Tipo Máquina: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_tipoMaq" name="input_tipoMaq" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="tipoMaq_1" name="tipoMaq_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('Server') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="tipoMaq_0" name="tipoMaq_0" class="mass-act" onClick="atribuiValor(this);"><?php echo _('Cliente') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr> 
                                          <tr>
                                            <td>Big Acumulado Min: </td>
                                            <td>
                                             	<input type="text" id="bigAcuMin" name="BigAcuMin" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                           
                                            </td>
                                          </tr>       
                                          <tr>
                                            <td>Big Acumulado Max: </td>
                                            <td>
												<input type="text" id="bigAcuMax" name="bigAcuMax" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                          
                                            </td>
                                          </tr>                                                     
                                          
                                          <tr>
                                            <td>Acumulado Big Actual: </td>
                                            <td>
                                             	<input type="text" id="bigAcuAtu" name="BigAcuAtu" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                          
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Acumulado Simples Min: </td>
                                            <td>
                                              	<input type="text" id="AcuMin" name="AcuMin" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                          
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Acumulado Simples Max: </td>
                                            <td>
                                             	<input type="text" id="AcuMax" name="AcuMax" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                           
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Acumulado Simples Actual: </td>
                                            <td>
                                            	<input type="text" id="AcuAtu" name="AcuAtu" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                           
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Valor del Jackpot: </td>
                                            <td>
                                              	<input type="text" id="vlJack" name="vlJack" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                           
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Limite de Doblar(creditos): </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_LimDobra" name="input_LimDobra" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="LimDobra_20000" name="LimDobra_20000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('2.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_25000" name="LimDobra_25000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('2.500.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_30000" name="LimDobra_30000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('3.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_35000" name="LimDobra_35000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('3.500.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_40000" name="LimDobra_40000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('4.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_45000" name="LimDobra_45000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('4.500.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_50000" name="LimDobra_40000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('5.000.000') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>DB: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_db" name="input_db" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="db_1" name="db_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('SI') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="db_1" name="db_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('NO') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>FAM Big: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_FamBig" name="input_FamBig" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="FamBig_1" name="FamBig_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('SI') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="FamBig_2" name="FamBig_2" class="mass-act" onClick="atribuiValor(this);"><?php echo _('NO') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>FAV Big: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_FavBig" name="input_FavBig" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="FavBig_A" name="FavBig_A" class="mass-act" onClick="atribuiValor(this);"><?php echo _('A') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="FavBig_B" name="FavBig_B" class="mass-act" onClick="atribuiValor(this);"><?php echo _('B') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="FavBig_C" name="FavBig_C" class="mass-act" onClick="atribuiValor(this);"><?php echo _('C') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="FavBig_D" name="FavBig_D" class="mass-act" onClick="atribuiValor(this);"><?php echo _('D') ?></a>
                                                  </li>                                                  
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>FAM: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_Fam" name="input_Fam" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="Fam_1" name="Fam_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('SI') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="Fam_0" name="Fam_0" class="mass-act" onClick="atribuiValor(this);"><?php echo _('NO') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>FAV: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_Fav" name="input_Fav" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="Fav_A" name="Fav_A" class="mass-act" onClick="atribuiValor(this);"><?php echo _('A') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="Fav_B" name="Fav_B" class="mass-act" onClick="atribuiValor(this);"><?php echo _('B') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="Fav_C" name="Fav_C" class="mass-act" onClick="atribuiValor(this);"><?php echo _('C') ?></a>
                                                  </li>
                                                  <li>
                                                    <a id="Fav_D" name="Fav_D" class="mass-act" onClick="atribuiValor(this);"><?php echo _('D') ?></a>
                                                  </li>                                                  
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Limite Auto-Cobrar, $: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_LimCobrar" name="input_LimCobrar" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="LimCobrar_2000" name="LimCobrar_2000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('2.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimCobrar_2500" name="LimCobrar_2500" class="mass-act" onClick="atribuiValor(this);"><?php echo _('2.500.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimCobrar_3000" name="LimCobrar_3000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('3.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimCobrar_3500" name="LimCobrar_3500" class="mass-act" onClick="atribuiValor(this);"><?php echo _('3.500.000') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Payout Key: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_pKey" name="input_pKey" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="pKey_1" name="pKey_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('SI') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pKey_0" name="pKey_0" class="mass-act" onClick="atribuiValor(this);"><?php echo _('NO') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <div class="row form-group">
                                    <div class="col-xs-12">
                                      <button id="btnReconfig" name="btnReconfig" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Actualizar') . $modal_item ?></button>
                                    </div>
                                  </div>                                  
                                  </form>
                                </div>

                                <!-- Tab Billetes Ingresados -->
                                <div role="tabpanel" class="tab-pane" id="money">
                                  <h6>Billetes ingresados</h6>
                                  <div class="table-responsive">
                        						<table id="tabelaUltimosBilhetes" class="table table-striped table-hover locales">
                        							<thead>
                        								<tr data-local="01">
                        									<th><?php echo _('$') ?></th>
                        									<th><?php echo _('Fecha') ?></th>
                        								</tr>
                        							</thead>
                        							<tbody>
                        								<tr data-local="02">
                        									<td>&nbsp;</td>
                        									<td>&nbsp;</td>
                        								</tr>
                        							</tbody>
                        						</table>
                        					</div>
                                </div>

                                <!-- Tab Juegos -->
                                <div role="tabpanel" class="tab-pane" id="games">
                                  <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                      <h6>Juegos</h6>

                                      <!-- Slider Imágenes -->
                                      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                        <!-- Indicators -->
                                        <ol class="carousel-indicators">
                                          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                        </ol>

                                        <!-- Wrapper for slides 
                                        <div class="carousel-inner" role="listbox">
                                          <div class="item active">
                                            <img src="img/1.png" alt="game">
                                            <div class="carousel-caption">
                                              Juego 2
                                            </div>
                                          </div>
                                          <div class="item">
                                            <img src="img/2.png" alt="game">
                                            <div class="carousel-caption">
                                              Juego 2
                                            </div>
                                          </div>
                                          <div class="item">
                                            <img src="img/3.png" alt="game">
                                            <div class="carousel-caption">
                                              Juego 2
                                            </div>
                                          </div>
                                        </div>-->




                                        <!-- Wrapper for slides -->
                                        <div id="div_jogos" class="carousel-inner" role="listbox">
                                          <div class="item active">
                                            <div class="carousel-caption">
                                              &nbsp;
                                            </div>
                                          </div>
                                        </div>

                                        <!-- Controls -->
                                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev" style="height:390px;">
                                          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                          <span class="sr-only">Anterior</span>
                                        </a>
                                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next" style="height:390px;">
                                          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                          <span class="sr-only">Siguiente</span>
                                        </a>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Tab Estadísticas -->
                                <div role="tabpanel" class="tab-pane" id="stats">
                                  <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                      <h6>Estadísticas</h6>
                                      <div class="table-responsive">
                            						<table id="tabelaStatistic" class="table table-striped table-hover locales">
                            							<thead>
                            								<tr data-local="01">
                            									<th><?php echo _('Itens') ?></th>
                            									<th><?php echo _('Creditos') ?></th>
                            									<th><?php echo _('Valor $') ?></th>
                            								</tr>
                            							</thead>
                            							<tbody>
                            								<tr data-local="02">
                            									<td>&nbsp;</td>
                            									<td>&nbsp;</td>
                            									<td>&nbsp;</td>
                            								</tr>
                            							</tbody>
                            						</table>
          					                  </div>
                  					        </div>
                        					</div>
                                </div>

                              </div>
                              <!-- fin tabs -->

                            </div>
                          </div>
                        </div>        
        
        
        
        
        
        
        
        
        


      </div>
    </div>
  </div>
</div>