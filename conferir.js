var LineByLineReader = require("line-by-line");
var fs = require("fs");
//02 18 24 36 57 59
const sorteados = ["02", "18", "24", "36", "57", "59"];

lr = new LineByLineReader("jogo2.txt");
lr.on("error", function (err) {
  console.log("Erro ao abrir arquivo");
});

lr.on("line", async function (line) {
  lr.pause();
  let arr = line.split("|");
  let contagem = 0;

  for (let i = 0; i < arr.length; i++) {
    if (sorteados.includes(arr[i])) {
      contagem++;
    }
  }

  if (contagem > 3) {
    SalvaRetorno(line, contagem);
  }

  lr.resume();
});

lr.on("end", function () {
  console.log("finalizado");
});

function SalvaRetorno(texto, pontos) {
  try {
    var logger = fs.createWriteStream("resultados_" + pontos + ".txt", {
      flags: "a", // 'a' means appending (old data will be preserved)
    });

    logger.write(texto + "\r\n");
    logger.end();
  } catch (err) {
    //console.log(err);
  }
}
