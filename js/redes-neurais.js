$(function () {

  verificaCampos();
  gerarLetras();

  // Ação de alterar o select para seleção do algorimo
  $(document).on('change', '#algoritmo', function(e){
    e.preventDefault();
    verificaCampos();
  });

  // Ação do botão "Iniciar Execução"
  $(document).on('click', '#executar', function(e){
    e.preventDefault();
    executar();
  });

  // Ação do botão "Gerar letra"
  $(document).on('click', '#gerar-letra', function(e){
    e.preventDefault();
    gerarLetra();
  });

  // Ação do botão "Classificar letra"
  $(document).on('click', '#classificar-letra', function(e){
    e.preventDefault();
    classificarLetra();
  });

  // Ação de clicar no tabuleiro para coloca/remove rainha na célula clicada pelo usuário
  $(document).on('click', '.letra-classificacao .celula', function(e) {
    e.preventDefault();
    trocarSimbolo($(this));
  });

  function executar() {
    var dados = $('#parametros').serialize();
    $.ajax({
      dataType: "json",
      type: 'POST',
      url: 'library/executar.php',
      async: true,
      data: dados,
      beforeSend: function(){
        $(".letras-exemplos").html("");
        $(".letras-exemplos").addClass("hide");
        $(".letras-classificadas").html("");
        $(".resultado-classificacao").addClass("hide");
        $('#executar').prop("disabled", true);
        abreModalCarregando();
      },
      success: function(response) {
        var classe = 0;
        var html = "";
        $.each(response, function (index, value) {
          classe = parseInt(index) + 1;
          html += "<div class='row'>";
          html += "<h2 class='page-header'>Classe: <strong>"+classe+"</strong></h2>";
          html += "<div class='classe"+classe+"'>";
          $.each(value, function (index, value) {
            html += montarLetra(value);
          });
          html += "</div>";
          html += "</div>";
        });
        $(".letras-classificadas").append(html);
      },
      complete: function(){
        $(".resultado-classificacao").removeClass("hide");
        $('#executar').prop("disabled", false);
        gerarLetra();
        fechaModalCarregando();
      }
    });
  };

  function verificaCampos() {
    var valueMax = 0;
    if ($('#algoritmo').val() === 'kohonen') {
      valueMax = 25;
      $('.quantidade_geracoes').removeClass('hide');
      $('.raio').removeClass('hide');
      $('.taxa_aprendizagem').removeClass('hide');
      $('.descrescimo_taxa_aprendizagem').removeClass('hide');
    } else {
      valueMax = 21;
      $('.quantidade_geracoes').addClass('hide');
      $('.raio').addClass('hide');
      $('.taxa_aprendizagem').addClass('hide');
      $('.descrescimo_taxa_aprendizagem').addClass('hide');
    }
    $('#quantidade_clusters').trigger('configure', {
      max: valueMax
    });
    $('#quantidade_clusters').val(valueMax);
  };

  function gerarLetras() {
    $.ajax({
      dataType: "json",
      type: 'POST',
      url: 'library/getLetras.php',
      async: true,
      data: {tipo: $("#tipo").val()},
      success: function(response) {
        $.each(response, function (index, value) {
          $(".letras-exemplos").append(montarLetra(value));
        });
      }
    });
  };

  function gerarLetra() {
    $.ajax({
      dataType: "json",
      type: 'POST',
      url: 'library/getLetra.php',
      async: true,
      data: {tipo: $("#tipo").val()},
      beforeSend: function(){
        $("#gerar-letra").addClass("disabled");
        $("#classificar-letra").addClass("disabled");
        $("#resultado-letra").addClass("hide");
      },
      success: function(response) {
        $(".letra-classificacao").html(montarLetra(response));
      },
      complete: function(){
        $("#gerar-letra").removeClass("disabled");
        $("#classificar-letra").removeClass("disabled");
      }
    });
  };

  function classificarLetra() {
    $.ajax({
      dataType: "json",
      type: 'POST',
      url: 'library/classificarLetra.php',
      async: true,
      data: {letra: getLetra(),
             tipo: $("#tipo").val()},
      beforeSend: function(){
        $("#gerar-letra").addClass("disabled");
        $("#classificar-letra").addClass("disabled");
        $("#resultado-letra").addClass("hide");
      },
      success: function(response) {
        var classe = 0;
        $.each(response, function (index, value) {
          classe = parseInt(index) + 1;
          $("#classe-resultado").html(classe);
          if ($(".classe"+classe).length) {
            $(".classe"+classe).append(montarLetra(value));
          } else {
            var html = "";
            html += "<div class='row'>";
            html += "<h2 class='page-header'>Classe: <strong>"+classe+"</strong></h2>";
            html += "<div class='classe"+classe+"'>";
            html += montarLetra(value);
            html += "</div>";
            html += "</div>";
            $(".letras-classificadas").append(html);
          }
        });
      },
      complete: function(){
        $("#gerar-letra").removeClass("disabled");
        $("#classificar-letra").removeClass("disabled");
        $("#resultado-letra").removeClass("hide");
      }
    });
  };

  function getLetra() {
    var vetor = [];
    $(".letra-classificacao .celula").each( function(index, value) {
      vetor.push($(this).text());
    });
    return vetor;
  }

  function trocarSimbolo(elemento) {
    var novo_simbolo = (elemento.text() === '#') ? '.' : '#';
    elemento.text(novo_simbolo);
  };

  function montarLetra(letra) {
    var nomeLetra = letra.nome !== null ? letra.nome : 'Exemplo';
    var count = 0;
    var html = "<div class='letra' style='float: left; margin-left: 40px;'>";
    html += "<h4 class='nome-letra'>"+nomeLetra+"</h4>";
    html += "<table class='tabuleiro'>";
    for (y = 0; y < 9; y++) {
      html += "<tr>";
      for (x = 0; x < 7; x++) {
        html += "<td class='celula'>"+letra.vetorSimbolo[count]+"</td>";
        count++;
      }
      html += "</tr>";
    }
    html += "</table>";
    html += "</div>";
    return html;
  };

  function abreModalCarregando() {
    $('html, body').animate({ scrollTop: $("body").offset().top }, 'slow');
    $('html, body').css("overflow-Y", "hidden");
    var id = '.carregando';
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
    $('#mask').css({'width':maskWidth,'height':maskHeight});
    $('#mask').fadeIn(1000);
    $('#mask').fadeTo("slow",0.8);
    var winH = $(window).height();
    var winW = $(window).width();
    $(id).css('top',  winH/2-$(id).height()/2);
    $(id).css('left', winW/2-$(id).width()/2);
    $(id).fadeIn(2000);
  };

  function fechaModalCarregando() {
    $('html, body').css("overflow-Y", "auto");
    $('#mask').hide();
    $('.window').hide();
  };

  $(".knob").knob({
    draw: function () {

      // "tron" case
      if (this.$.data('skin') == 'tron') {

        var a = this.angle(this.cv)  // Angle
                , sa = this.startAngle          // Previous start angle
                , sat = this.startAngle         // Start angle
                , ea                            // Previous end angle
                , eat = sat + a                 // End angle
                , r = true;

        this.g.lineWidth = this.lineWidth;

        this.o.cursor
                && (sat = eat - 0.3)
                && (eat = eat + 0.3);

        if (this.o.displayPrevious) {
          ea = this.startAngle + this.angle(this.value);
          this.o.cursor
                  && (sa = ea - 0.3)
                  && (ea = ea + 0.3);
          this.g.beginPath();
          this.g.strokeStyle = this.previousColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
          this.g.stroke();
        }

        this.g.beginPath();
        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
        this.g.stroke();

        this.g.lineWidth = 2;
        this.g.beginPath();
        this.g.strokeStyle = this.o.fgColor;
        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
        this.g.stroke();

        return false;
      }
    }
  });
});