// määrittää tuoteelle luokan Product
class Product {
    
    // luokan konstruktori-funktio, pakottaa kullekin oliolle nimen ja hinnan
    constructor(name, price) {
        this.name = name;
        this.price = price;
    }

    // tulostaa olion nimestä ja hinnasta taulukkorivin HTML-dokumenttia varten
    printDetails() {
        return `<tr><td>${this.name}</td><td>${this.price}</td>`;
    }

}

// päivittää tuotelistan heti kun web-sivu latautuu
updateProductList();

// päivittää HTML-sivulla olevan Tuotekatalogi-taulukon hakemalla
// tuotelistan tietokannasta
function updateProductList() {

    // alustaa tuotelistan muistiin taulukkona
    const productList = [];

    // tekee GET-metodin API-pyynnön
    fetch("api.php", {
        method: "GET",
    })
    // API palauttaa aina JSON-tyyppisen datan (määritelty api.php:ssa)
    .then(response => response.json())
    .then(data => {
        // käy läpi vastauksena saadun tuotelistan JSON taulukkomuodossa
        data.forEach(product => {
            
            // luo uuden tuote-olion ja lisää sen samantien tuotelistalle
            productList.push(new Product(product.name, product.price));

            // alustaa lopullisen HTML-taulukkorivityksen tuoteolion
            // printDetails-funktiota käyttäen
            let products = "";
            for (let i = 0; i < productList.length; i++) {
                products += productList[i].printDetails();
            }

            // syöttää taulukkorivityksen HTML-dokumenttiin oikeaan paikkaan
            document.getElementById("productList").innerHTML = products;
        });
    });
}

// lisää tuotteen tietokantaan ja päivittää HTML-sivulla olevan taulukon
function addProduct() {
    // hakee tuotteen tiedot syötekentistä
    const name = document.getElementById("name").value;
    const price = document.getElementById("price").value;

    // luo tuoteolion syötekenttien tiedoista
    const product = new Product(name, price);

    // lähettää tuoteolion JSON-muodossa POST-tyyppisellä API-kutsulla
    fetch("api.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(product)
    })

    // API palauttaa aina JSON-tyyppisen datan (määritelty api.php:ssa)
    .then(response => response.json())

    // merkitsee API:n palauttaman tuloksen msg-nimiseen kenttään
    .then(data => {
        if (data.success) {
            document.getElementById("msg").textContent = "OK!"
        } else {
            document.getElementById("msg").textContent = "Virhe!"
        }
        // päivittää HTML-sivulla olevan taulukon
        updateProductList();
    });
   
}