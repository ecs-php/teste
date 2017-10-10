import React, {Component} from 'react';
import {Icon} from "react-materialize";
import Request from "axios";
import './App.css';

class App extends Component {

    constructor(...arg){
        super(...arg);

        this.state = {
            loading : true,
            winners: [],
            lottery : []
        }

    }

    componentDidMount() {
        window.jQuery("[data-activates='nav-mobile']").sideNav();
        window.jQuery('.modal').modal({ dismissible: true});
        Request.get('http://localhost:7700/calendar')
            .then( payload => {
                this.setState({
                    lottery : payload.data
                })
            })
        Request.get('http://localhost:7700/winners')
            .then( payload => {
                this.setState({
                    winners : payload.data
                })
            })
    }

    render() {

        let lottery = this.state.lottery;
        let winners = this.state.winners;

        return (
            <div>
                <div className="navbar-fixed">
                    <nav className="white" role="navigation">
                        <div className="nav-wrapper container">
                            <div className="brand-logo">
                                <div className="logo-sprite"></div>
                            </div>
                            <ul className="right hide-on-med-and-down">
                                <li><a>Como Participar</a></li>
                                <li><a>Prêmios e Sorteios</a></li>
                                <li><a>Ganhadores</a></li>
                                <li><a>Regulamento</a></li>
                                <li><a className="btn btn-take-part">participe já, é grátis</a></li>
                            </ul>
                            <a href="#" data-activates="nav-mobile" className="button-collapse">
                                <Icon className={"burguer"}>menu</Icon>
                            </a>
                        </div>
                    </nav>
                </div>
                <ul id="nav-mobile" className="side-nav">
                    <li><a>Como Participar</a></li>
                    <li><a>Prêmios e Sorteios</a></li>
                    <li><a>Ganhadores</a></li>
                    <li><a>Regulamento</a></li>
                    <li><a className="btn btn-take-part">participe já, é grátis</a></li>
                </ul>

                <div id="modal" className="modal modal-fixed-footer">
                    <iframe width="100%" height="415" src="https://www.youtube.com/embed/UnMkKyZc5DA?rel=0&amp;showinfo=0" ></iframe>
                    <button className="btn btn-core uppercase modal-close right">Fechar</button>
                </div>

                <div className="banner">
                    <div className="container">
                        <div className="row">
                            <div className="col s12 m6 l6 xl6 white-text center">
                                <ul className="collection banner-collection">
                                    <li className="collection-item">O SerasaConsumidor</li>
                                    <li className="collection-item">ajuda a <span className="banner-text-pay">pagar sua dívida!</span>
                                    </li>
                                    <li className="collection-item">Abra seu Cadastro Positivo e concorra a</li>
                                    <li className="collection-item">
                                        <span className="banner-text-price">
                                          <small>R$</small> 5.000<small>,00</small>
                                        </span>
                                    </li>
                                    <li className="collection-item">
                                        <button className="btn btn-banner">participe já, é grátis</button>
                                    </li>
                                    <li className="collection-item banner-more ">
                                        Saiba o que é o <a className="modal-trigger" href="#modal">Cadastro Positivo</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 className="center text-info-awards">Quer saber como abrir seu Castro Positivo e ainda concorrer a
                    prêmios?</h2>

                <div className="container">
                    <div className="row center step-by-step">
                        <div className="col s12 m4 l4 xl4">
                            <div className="ico-step-1"></div>
                            <span className="text-core">1. <small
                                className="text-core-grey">Cadastre-se no</small> </span><br/>
                            <span className="text-core uppercase">serasaconsumidor</span>
                        </div>
                        <div className="col s12 m4 l4 xl4">
                            <div className="ico-step-2"></div>
                            <span className="text-core">2. <small
                                className="text-core-grey">Abra o seu</small> </span><br/>
                            <span className="text-core uppercase">cadastro positivo</span>
                        </div>
                        <div className="col s12 m4 l4 xl4">
                            <div className="ico-step-3"></div>
                            <span className="text-core">
                                3. <small className="text-core-grey">Receba seu </small>número e data do sorteio
                                <small className="text-core-grey"> no seu e-mail</small> <br/>
                                <small className="text-core-grey">(Cadas CPF participa de apenas um sorteio)</small>
                            </span>

                        </div>
                    </div>

                    <div className="row">
                        <div className="col s12 center">
                            <button className="btn center btn-core uppercase">participe já, é grátis</button>
                        </div>
                    </div>


                </div>


                <div className="row block-info-awards">
                    <div className="col s12 m7 l7 xl7 grey lighten-5">
                        <div className="col s12 m8 l10 xl10 right">
                            <h5 className="text-core-grey">Abrindo seu Cadastro Positivo você pode ganhar <br/>até
                                <span className="upper-price"> R$ 5.000!</span>
                            </h5>
                            <p className="text-core-grey">Cada CPF participa de apenas um sorteio. Assim que seu
                                <span className="bold text-core-bold" > Cadastro Positivo</span> for
                                concluído, você vai receber por e-mail o seu número da sorte e a data do sorteio
                                que você vai participar. Depois, é só torcer para ser o ganhador.</p>
                        </div>
                    </div>
                    <div className="col col s12 m5 l5 xl5 grey lighten-4">
                        <div className="col s12 m8 l8 xl8 left">

                            <div className="row margin-1">
                                <div className="col s4">
                                    <div className="ico-calendar">
                                        <div className="center number-calendar" >14/09</div>
                                    </div>
                                </div>
                                <div className="col s8 left-align">
                                    <div className="next-lottery" >Próximo sorteio</div>
                                </div>
                            </div>
                            <p className="center" >
                                <button className="btn center btn-core uppercase">participe já, é grátis</button>
                            </p>
                        </div>
                    </div>
                </div>

                <div className="container text-core-grey" id="winners" >
                    <div className="row">
                        <div className="col s12 m8 l8 xl8">
                            <h5 style={{marginLeft:"20px"}} >Ganhadores</h5>

                            {
                                winners.map( val => {
                                    return <div className="col s12 m6 l6 xl6">
                                        <div className="col s3">
                                            <div className="ico-calendar-yellow">
                                                <div className="center number-calendar" >{val.date}</div>
                                            </div>
                                        </div>
                                        <div className="col s9">
                                            <span className="text-core-secondary bold" >{val.city}</span> <br/>
                                            <span>Número sorteado: {val.number}</span>
                                        </div>
                                    </div>
                                })
                            }

                        </div>
                        <div className="col s12 m4 l4 xl4">
                            <h5>Data dos sorteios</h5>
                            <ul id="list-calendar-lottery" >
                                {
                                    lottery.map( ( val , key ) => {
                                        let classIco = key > 13 ? 'ico-calendar-lottery': 'ico-calendar-lottery-disabled';
                                        return <li>
                                            <div  className={classIco} >
                                                <div className="center number-calendar" >{val}</div>
                                            </div>
                                        </li>
                                    })
                                }
                            </ul>
                        </div>
                    </div>
                </div>

                <footer>
                    <div id="footer-header">
                        <div className="container">
                            <div className="row">
                                <div className="col s12 m6 l6 xl6">
                                    <p>
                                        2015 Serasa Experian. Todos os direitos reservados.
                                        SERASA S. A. com sede na Alameda dos Quinimuras, 187, Planalto Paulista, CEP 04068-900, São Paulo, SP
                                        Inscrita no CNPJ/MF nº 62.173.620/0001-80, IE Isenta. www.serasaexperian.com.br
                                    </p>
                                </div>
                                <div className="col s12 m6 l6 xl6 right-align">
                                    <p>
                                        O SerasaConsumidor se comunica diretamente com os ganhadores da promoção e nunca solicita nenhum pagamento para resgate de prêmio. Em caso de dúvida, entre em contato com nossa Central de Atendimento Cadastro Positivo 0800 776 6606.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="container center">
                            Certificado de autorização da Caixa 4-2936/2016.
                            Promoção válida 08/11/16 à 27/03/17. Cada CPF concorrerá somente a
                            um sorteio no valor de R$5.000 durante a promoção. Participação vinculada a
                            abertura do Cadastro Positivo nos sites e agências Serasa. Sorteios via extração
                            da Loteria Federal. Consulte as datas de sorteios, as condições de participação
                            e o regulamento completos no site
                            www.serasaconsumidor.com.br/sorteiocadastropositivo
                    </div>
                </footer>

            </div>
        );
    }
}

export default App;
