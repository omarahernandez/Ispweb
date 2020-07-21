<?php 
session_start();
if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) 
		{
		header('Location: login/index.php');
		exit;
		}
else    {
		$user=$_SESSION['username'];
		}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <title>Wisdev-Administrador ISP</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:300,400,500" rel="stylesheet" />
    <link rel="stylesheet" href="css/fontello.css" />
    <link rel="stylesheet" href="css/animation.css">
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <h1>Isp Experts <h4>Monitoreo y administraciòn</h4>
            </h1>
        </div>
        <div class="header-box">
            <div class="user">
                <i class="icon-user"></i><span><?php echo "Hola ".$_SESSION['username'];?></span>
            </div>
            <div class="button-collapse">
                <button>☰</button>
            </div>
        </div>
    </header>
    <nav class="navTop">
        <ul>
            <li><a href="#"><i class="icon-money"></i>Registrar Pago</a></li>
            <li><a href="#"><i class="icon-print"></i>Transacciones</a></li>
            <li><a href="#"><i class="icon-money"></i>Formato Recibo</a></li>
        </ul>
    </nav>
    <main id="app">
        <nav class="navLeft">
            <ul>
                <li class="selected"><a href="#"><i class="icon-pinboard"></i><span>Tickets</span></a></li>
                <li><a href="#"><i class="icon-docs"></i><span>Facturas</span></a></li>
                <li><a href="#"><i class="icon-users"></i><span>Clientes</span></a></li>
                <li><a href="#"><i class="icon-network"></i><span>Mktik</span></a></li>
                <li><a href="#"><i class="icon-money"></i><span>Egresos</span></a></li>
                <li><a href="#"><i class="icon-logout"></i><span>Salir</span></a></li>
            </ul>
        </nav>
        <section>
            <div class="section-title">
                <img src="img/support.png" alt="">
                <h1>ADMINISTRAR TICKETS DE SOPORTE TÈCNICO</h1>
            </div>
            <div class=box-container>
                <div class="box box-new-ticket">
                    <div class="title">
                        <h3><i class="icon-user"></i> Nuevo Ticket</h3>
                    </div>
                    <div class="box-content">
                        <div class="search">
                            <input v-model="searchClientContent"  type="text" placeholder="Nombre de Cliente">
                            <button  v-on:click="searchClient"><i class="icon-search"></i></button>
                        </div>
                        <div v-bind:class="{'hide-box-result':hideTicketResult}"  >
                            <div class="title">
                                <h3 class="icon-docs">Result</h3>
                            </div>
                            <div class="result-content">
                                <div class="result-container">
                                    <div>
                                        <p>Selecciona cliente.</p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>Ip Address</th>
    
                                                    <th>Recibe</th>
                                                    <th class="close-result-table" >
                                                        <div><span>Fecha</span></div>
                                                        <div><button @click="closeResultTable" class="icon-cancel"></button></div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="client in clientes" :key="client.id" @click="selectedRowNewTicket(client.id,client.cliente)" >
                                                    <td>{{client.cliente}}</td>
                                                    <td>{{client.ip}}</td>

                                                    <td>{{client.recibe}}</td>
                                                    <td>{{client.fecha}}</td>
                                                </tr>
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>{{totalRows}} rows</td>
                                                    <td></td>

                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="selected-client">
                                        <p>Cliente seleccionado</p>
                                        <input type="text"  :value="newTicketSelectedClient">
                                        <input type="hidden" id="newTicketForId" :value="newTicketSelectedId" >
                                        <button @click="continueToResultModal(true)">Continuar</button><button @click="closeResultTable" class="icon-cancel"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box new-ticket " v-bind:class="{'hide-new-ticket':hideResultModal}" >
                    <div class="new-ticket-modal-content">
                        <form v-on:submit.prevent="checkForm">
                            <div class="title-modal">
                                <h3>Registrar Nuevo Ticket</h3>
                            </div>
                            <div class="form-new-ticket">
                                <div class="form-group new-cli">
                                    <label for="cli">Cliente</label>
                                    <input type="text" id="cli" value="Kevin">
                                </div>
                                <div class="form-group new-cli">
                                    <label for="clientTelefono">Telèfono de Cliente</label>
                                    <input type="text" name="telefono" id="clientTelefono" value="3147654655">
                                </div>
                                <div class="form-group new-cli">
                                    <label for="clientTelefonoAdicional">Telèfono Adicional</label>
                                    <input type="text" name="telefono" id="clientTelefonoAdicional" value="3215450397">
                                </div>
                                <div class="form-group new-cli">
                                    <label for="direccion">Direcciòn</label>
                                    <input type="text" name="direccion" id="direccion" value="Cra 9#13-45">
                                </div>
                                <div class="form-group new-cli">
                                    <label for="email">Email de cliente</label>
                                    <input type="email" name="email" id="email" value="omar_alberto_h@yahoo.es">
                                </div>
                                <div class="form-group new-cli">
                                    <label for="ipAddre">Ip Address</label>
                                    <input type="text" name="ipAddre"  id="ipAddre" value="192.168.1.2">
                                </div>
                                <div class="form-group new-cli w100">
                                    <label for="diagnostico">Solicitud de Cliente</label>
                                    <textarea required minlength="6" rows="10" cols="" id="diagnostico"></textarea>
                                </div>
                                <div class="form-group new-cli w100">
                                    <label for="solucion">Sugerencia de soluciòn</label>
                                    <textarea required minlength="6" rows="10" cols="" id="solucion"></textarea>
                                </div>
                            </div>
                            <div class="footer-modal">
                            <input type="submit" value="Enviar"><button class="icon-cancel" @click="continueToResultModal(false)"></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box">
                    <div class="title">
                        <h3><i class="icon-wrench"></i> Tickets Abiertos</h3>
                    </div>
                    <div >
                        <div class="box-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Ip Address</th>
                                        <th>Tècnico</th>
                                        <th>Recibe</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ticketAbierto in ticketsAbiertos" :key="ticketAbierto.id" @click="selectedRowTicketAbiero(ticketAbierto.id,ticketAbierto.cliente)" >
                                        <td>{{ticketAbierto.cliente}}</td>
                                        <td>{{ticketAbierto.ip}}</td>
                                        <td>{{ticketAbierto.tecnico}}</td>
                                        <td>{{ticketAbierto.recibe}}</td>
                                        <td>{{ticketAbierto.fecha}}</td>
                                    </tr>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Cliente</td>
                                        <td>Ip Address</td>
                                        <td>Tècnico</td>
                                        <td>Recibe</td>
                                        <td>Fecha</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="selected-client">
                        <p>Cliente seleccionado</p>
                        <input type="text" :value="AbiertoTicketSelectedClient">
                        <input type="text" id="" :value="AbiertoTicketSelectedid">
                        <button>Continuar</button><button class="icon-cancel"></button>
                    </div>
                    <div class="close-ticket-modal">
                        <div class="close-ticket-content">
                            <div class="title-modal">
                                <h3>Cerrar Ticket</h3>
                            </div>
                            <div class="form-close-ticket">
                                <div class="form-group">
                                    <label for="cliente">Cliente</label>
                                    <input type="text" id="cliente">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Telèfono</label>
                                    <input type="text" name="telefono" id="telefono" value="">
                                </div>
                                <div class="form-group">
                                    <label for="clientAdd">Direcciòn</label>
                                    <input type="text" name="clientAdd" value="" id="clientAdd">
                                </div>
                                <div class="form-group">
                                    <label for="clientEmail">Email de cliente</label>
                                    <input type="email" name="email" value="" id="clientEmail">
                                </div>
                                <div class="form-group">
                                    <label for="ipAddress">Ip Address</label>
                                    <input type="text" name="ipAddress" value="" id="ipAddress">
                                </div>
                                <div class="form-group">
                                    <label for="routerModel">Marca de Router</label>
                                    <input type="text" name="routerModel" value="" id="routerModel">
                                </div>
                                <div class="select-group">
                                    <div class="form-group"> 
                                        <label for="router-remote-admin">Acceso Remoto</label>
                                        <select name="router-remote-admin"  id="router-remote-admin">
                                            <option value="yes">Yes</option>
                                            <option selected value="no">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="tipo-antena">Tipo de Antena</label>
                                        <select name="tipo-antena"  id="tipo-antena">
                                            <option value="mikrotik">Mikrotik</option>
                                            <option value="ubiquiti">Ubiquiti</option>
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="tipo-antena">Tipo de Antena</label>
                                        <select name="tipo-antena"  id="tipo-antena">
                                            <option value="mikrotik">Mikrotik</option>
                                            <option value="ubiquiti">Ubiquiti</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="diagnostico">Solicitud de Cliente</label>
                                    <textarea  cols="" id="diagnostico"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="solucion">Describir soluciòn</label>
                                    <textarea  cols="" id="solucion"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="sugerencias">Sugerencias</label>
                                    <textarea  cols="" id="sugerencias"></textarea>
                                </div>
                            </div>
                            <div class="footer-modal">
                                <button>Enviar</button><button>Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="title">
                        <h3><i class="icon-wrench"></i> Tickets Cerrados</h3>
                    </div>
                    <div >
                        <div class="box-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Ip Address</th>
                                        <th>Tècnico</th>
                                        <th>Recibe</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Mario</td>
                                        <td>192.168.1.2</td>
                                        <td>Juan Pablo</td>
                                        <td>Ignacio Loyola</td>
                                        <td>12/07/2020</td>
                                    </tr>
                                    <tr>
                                        <td>Ivàn</td>
                                        <td>192.168.1.3</td>
                                        <td>Juan Pablo</td>
                                        <td>Federico Velèz</td>
                                        <td>13/07/2020</td>
                                    </tr>
                                    <tr>
                                        <td>Oscar Guzmàn</td>
                                        <td>192.168.1.4</td>
                                        <td>Sebastian</td>
                                        <td>Eduardo Gòmez</td>
                                        <td>14/07/2020</td>
                                    </tr>
                                    <tr>
                                        <td>Fabian Castro</td>
                                        <td>192.168.1.5</td>
                                        <td>Juan Pablo</td>
                                        <td>Hermes Padilla</td>
                                        <td>15/07/2020</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Cliente</td>
                                        <td>Ip Address</td>
                                        <td>Tècnico</td>
                                        <td>Recibe</td>
                                        <td>Fecha</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="selected-client">
                        <p>Cliente seleccionado</p>
                        <input type="text" value="Oscar Guzman">
                        <input type="hidden" id="" value="325">
                        <button>Continuar</button><button class="icon-cancel"></button>
                    </div>
                </div>
                <div class="box box-statitics">
                    <div class="title">
                        <h3><i class="icon-chart-line"></i> Statitics</h3>
                    </div>
                    <div class="resume">
                        <div class="title">
                            <h3>JULIO</h3>
                        </div>
                        <div class="content">
                            <div class="box-child">
                                <h1>50</h1>
                                <p>SOPORTES</p>
                            </div>
                            <div class="box-child">
                                <h1>25</h1>
                                <p>JUAN PABLO</p>
                            </div>
                            <div class="box-child">
                                <h1>25</h1>
                                <p>SEBASTIAN</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
    </main>
    <footer>
        <div>
            <span>Isp Experts- Adminstraciòn Redes </span>
        </div>

    </footer>
</body>
<script>
var app = new Vue({
    el: "#app",
    data: {
       searchClientContent: "",
       clientes: [],
       ticketsAbiertos: [],
       ticketsCerrados: [],
       totalRows: "",
       newTicketSelectedClient: "",
       newTicketSelectedId:"",
       AbiertoTicketSelectedClient: "",
       AbiertoTicketSelectedId: "",
       hideTicketResult:true,
       hideResultModal: true,
       hideTicketAbiertoModal:true
    },
    methods: {
        checkForm: function(){
            console.log("prevent default")
        },
        continueToResultModal: function(data){
            if(data)
                this.hideResultModal=false
            else
            this.hideResultModal=true
        },
        closeResultTable: function(){
            this.hideTicketResult=true
        },
        searchClient: function(){
            console.log("cllicked  .. and search:"+this.searchClientContent)
            this.getUser()
        },
        getUser: function() {
            axios.get('fetchClientList.php', {
                params: {
                    searchClientContent: this.searchClientContent
                } 
            }).then(response => {
                this.totalRows=response.data.length
                this.clientes=response.data
                this.hideTicketResult=false
                
            }).catch(e => {
                console.log('error' + e)
            })
        },        
        getTicketAbierto: function() {
            axios.get('fetchTicketAbiertos.php', {
            }).then(response => {
                this.totalRows=response.data.length
                this.ticketsAbiertos=response.data
            }).catch(e => {
                console.log('error' + e)
            })
        },
        selectedRowTicketAbiero: function(id,client){
            this.AbiertoTicketSelectedClient=client
            this.AbiertoTicketSelectedId=id
        },
        selectedRowNewTicket: function(id,client){
            this.newTicketSelectedId=id
            this.newTicketSelectedClient=client
        },
        validateIpAddress: function(data) {
            var ipformat =
                /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
            if (data != null) {
                if (data.match(ipformat)) {
                    return true;
                } else {

                    return false;
                }
            }
            return false;
        }
    },
    mounted() {
        this.getTicketAbierto()
    },
});
</script>
</body>

</html>