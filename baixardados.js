const axios = require("axios");
var fs = require("fs");

function processa(id) {
  axios
    .post("https://www.sorteonline.com.br/mega-sena/cartao/6672209/" + id, {
      numeroConcurso: 2440,
      apenasPremiados: false,
    })
    .then(async (res) => {
      console.log(`statusCode: ${res.status}`);
      let retorno = res.data;
      let arraylist = retorno.split('<div class="dozens">');
      for (let i = 1; i < arraylist.length; i++) {
        let jogo = arraylist[i];
        let arrayjogo = jogo.split('<span class="card-dz">');
        let jogofinal = "";
        for (let i = 1; i < arrayjogo.length; i++) {
          jogofinal = jogofinal + arrayjogo[i].split("<")[0] + "|";
        }

        console.log(jogofinal);
        await SalvaRetorno(jogofinal);
      }

      await sleep(500);
      processa(id + 1);
    })
    .catch((error) => {
      processa(id);
      console.error(error);
    });
}

processa(1);

function SalvaRetorno(texto) {
  try {
    var logger = fs.createWriteStream("jogo2.txt", {
      flags: "a", // 'a' means appending (old data will be preserved)
    });

    logger.write(texto + "\r\n");
    logger.end();
  } catch (err) {
    //console.log(err);
  }
}

function sleep(ms) {
  return new Promise((resolve) => {
    setTimeout(resolve, ms);
  });
}
