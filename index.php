<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Trabalho da disciplina Aprendizado de Máquina da faculdade UNISUL, para trabalhar com os algoritmos de Kohonen e Kmeans." />
        <meta name="author" content="Rodrigo Sypriano Ribeiro">
        <title>Kohonen e Kmeans | Aprendizado de Máquina</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animate.min.css" rel="stylesheet">
        <link href="css/lightbox.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">
        <link href="css/rainbow/blackboard.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="images/ico/favicon.ico">
    </head><!--/head-->

    <body>
        <header id="header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 overflow">
                       <div class="social-icons pull-right">
                            <ul class="nav nav-pills">
                                <li><a href="https://github.com/RodrigoSyprianoRibeiro/kohonen-kmeans" target="_blank"><i class="fa fa-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="navbar navbar-inverse" role="banner">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="">
                            <h1>
                                <img src="images/logo-kohonen.png" alt="logo-kohonen">
                                Kohonen e Kmeans
                                <img src="images/logo-kmeans.png" alt="logo-kmeans">
                            </h1>
                        </a>

                    </div>
                </div>
            </div>
        </header>
        <!--/#header-->

        <section id="services">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul id="tab1" class="nav nav-tabs">
                            <li class="active"><a href="#tab1-item1" data-toggle="tab">Execução</a></li>
                            <li><a href="#tab1-item2" data-toggle="tab">Código</a></li>
                            <li><a href="#tab1-item3" data-toggle="tab">Sobre</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="tab1-item1">
                                <div class="col-sm-3 wow fadeIn padding-top text-center" data-wow-duration="500ms" data-wow-delay="300ms">
                                    <form id="parametros" class="form-horizontal">
                                        <div class="col-md-12 margin-bottom text-center">
                                            <div class="knob-label">Algoritmo para classificação</div>
                                            <select id="algoritmo" name="algoritmo" >
                                                <option value="kohonen">Kohonen</option>
                                                <option value="kmeans">Kmeans</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 margin-bottom text-center">
                                            <div class="knob-label">Quantidade de clusters</div>
                                            <input type="text" id="quantidade_clusters" name="quantidade_clusters" class="knob" value="25" data-min="1" data-max="25" data-width="60" data-height="60" data-fgColor="#3c8dbc"/>
                                        </div><!-- ./col -->
                                        <div class="col-md-12 margin-bottom text-center quantidade_geracoes">
                                            <div class="knob-label">Quantidade de gerações</div>
                                            <input type="text" id="quantidade_geracoes" name="quantidade_geracoes" class="knob" value="3000" data-min="1" data-max="10000" data-width="60" data-height="60" data-fgColor="#f56954"/>
                                        </div><!-- ./col -->
                                        <div class="col-md-12 margin-bottom text-center raio">
                                            <div class="knob-label">Raio da vizinhança</div>
                                            <input type="text" id="raio" name="raio" class="knob" value="0" data-min="0" data-max="5" data-width="60" data-height="60" data-fgColor="#00a65a"/>
                                        </div><!-- ./col -->
                                        <div class="col-md-12 margin-bottom text-center taxa_aprendizagem">
                                            <div class="knob-label">% Taxa de aprendizagem</div>
                                            <input type="text" id="taxa_aprendizagem" name="taxa_aprendizagem" class="knob" value="60" data-min="0" data-max="100" data-width="60" data-height="60" data-fgColor="#00c0ef"/>
                                        </div><!-- ./col -->
                                        <div class="col-md-12 margin-bottom text-center descrescimo_taxa_aprendizagem">
                                            <div class="knob-label">% Descréscimo taxa de aprendizagem</div>
                                            <input type="text" id="descrescimo_taxa_aprendizagem" name="descrescimo_taxa_aprendizagem" class="knob" value="1" data-min="0" data-max="100" data-width="60" data-height="60" data-fgColor="#00c0ef"/>
                                        </div><!-- ./col -->
                                        <div class="col-md-12 margin-bottom text-center">
                                            <div class="knob-label">Tipo de representação</div>
                                            <select id="tipo" name="tipo" >
                                                <option value="bipolar">Bipolar</option>
                                                <option value="binario">Binário</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <button type="button" id="executar" class="btn btn-lg btn-success">Iniciar Execução</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-9 wow fadeIn" data-wow-duration="500ms" data-wow-delay="300ms">
                                    <div class="row letras-exemplos">
                                    </div>
                                    <div class="row resultado-classificacao hide">
                                        <div class="col-sm-9 letras-classificadas"></div>
                                        <div class="col-sm-3 padding-top text-center">
                                            <div class="row text-center">
                                                Classificar letra:
                                                <div class="letra-classificacao"></div>
                                            </div>
                                            <div class="row">
                                                <button type="button" id="gerar-letra" class="btn btn-lg btn-primary margin-bottom"><i class="fa fa-refresh"></i> Gerar Letra</button>
                                            </div>
                                            <div class="row">
                                                <button type="button" id="classificar-letra" class="btn btn-lg btn-success"><i class="fa fa-flask"></i> Classificar letra</button>
                                            </div>
                                            <div id="resultado-letra" class="row text-center hide">
                                                <h2>Letra acima é da classe:</h2>
                                                <h1 id="classe-resultado"></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab1-item2">
                                <div class="col-sm-12 wow fadeIn" data-wow-duration="500ms" data-wow-delay="300ms">
                                    <h2 class="page-header">Código <strong>Fonte</strong></h2>
                                    <a href="https://github.com/RodrigoSyprianoRibeiro/kohonen-kmeans" target="_blank"><i class="fa fa-github"></i> GitHub</a>
                                    <div class="col-md-12">
                                        <ul id="tab2" class="nav nav-tabs">
                                            <li class="active"><a href="#tab2-item1" data-toggle="tab">HTML</a></li>
                                            <li><a href="#tab2-item2" data-toggle="tab">JS</a></li>
                                            <li><a href="#tab2-item3" data-toggle="tab">executar.php</a></li>
                                            <li><a href="#tab2-item4" data-toggle="tab">classificarLetra.php</a></li>
                                            <li><a href="#tab2-item5" data-toggle="tab">Kohonen.php</a></li>
                                            <li><a href="#tab2-item6" data-toggle="tab">Kmeans.php</a></li>
                                            <li><a href="#tab2-item7" data-toggle="tab">Arquivo.php</a></li>
                                            <li><a href="#tab2-item8" data-toggle="tab">Letra.php</a></li>
                                            <li><a href="#tab2-item9" data-toggle="tab">Util.php</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab2-item1">
                                                <pre><code data-language="html"><?php include 'docs/html.txt'; ?><</code></pre>
                                            </div>
                                            <div class="tab-pane fade" id="tab2-item2">
                                                <pre><code data-language="javascript"><?php include 'docs/js.txt'; ?></code></pre>
                                            </div>
                                            <div class="tab-pane fade" id="tab2-item3">
                                                <pre><code data-language="php"><?php include 'docs/executar.txt'; ?></code></pre>
                                            </div>
                                            <div class="tab-pane fade" id="tab2-item4">
                                                <pre><code data-language="php"><?php include 'docs/classificarletra.txt'; ?></code></pre>
                                            </div>
                                            <div class="tab-pane fade" id="tab2-item5">
                                                <pre><code data-language="php"><?php include 'docs/kohonen.txt'; ?></code></pre>
                                            </div>
                                            <div class="tab-pane fade" id="tab2-item6">
                                                <pre><code data-language="php"><?php include 'docs/kmeans.txt'; ?></code></pre>
                                            </div>
                                            <div class="tab-pane fade" id="tab2-item7">
                                                <pre><code data-language="php"><?php include 'docs/arquivo.txt'; ?></code></pre>
                                            </div>
                                            <div class="tab-pane fade" id="tab2-item8">
                                                <pre><code data-language="php"><?php include 'docs/letra.txt'; ?></code></pre>
                                            </div>
                                            <div class="tab-pane fade" id="tab2-item9">
                                                <pre><code data-language="php"><?php include 'docs/util.txt'; ?></code></pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab1-item3">
                                <div class="col-sm-12 wow fadeIn" data-wow-duration="500ms" data-wow-delay="300ms">
                                    <h2 class="page-header"><strong>Autores</strong></h2>
                                    <blockquote>
                                        <p>Rodrigo Ribeiro e Renato Paschoal de Araujo.</p>

                                        <footer>Trabalho da disciplina <cite title="Aprendizado de Máquina">Aprendizado de Máquina</cite>
                                        do curso de Ciência da Computação da UNISUL (Universidade do Sul de Santa Catarina).</footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/#services-->

        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center bottom-separator">
                        <img src="images/home/under.png" class="img-responsive inline" alt="">
                    </div>
                    <div class="col-sm-12">
                        <div class="copyright-text text-center">
                            <p>&copy; Rodrigo Ribeiro 2016. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--/#footer-->

        <div class="carregando window">
            <img src="images/carregando.gif" alt="Carregando" />
        </div>
        <div id="mask"></div>

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/lightbox.min.js"></script>
        <script type="text/javascript" src="js/wow.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="js/bootbox.js"></script>
        <script type="text/javascript" src="js/jquery.knob.js"></script>
        <script type="text/javascript" src="js/redes-neurais.js"></script>
        <script type="text/javascript" src="js/rainbow/rainbow.min.js"></script>
        <script type="text/javascript" src="js/rainbow/language/css.js"></script>
        <script type="text/javascript" src="js/rainbow/language/generic.js"></script>
        <script type="text/javascript" src="js/rainbow/language/html.js"></script>
        <script type="text/javascript" src="js/rainbow/language/javascript.js"></script>
        <script type="text/javascript" src="js/rainbow/language/php.js"></script>
        <script type="text/javascript" src="js/rainbow/language/shell.js"></script>
    </body>
</html>
