fetch("api.php")
    .then(response => response.json())
    .then(cars=> {

        let text = "";

        cars.forEach(car => {

            text += `
                <p>
                    🚗 ${car.make} ${car.model}
                    (${car.year})
                </p>
            `;
        });

        document.getElementById("cars").innerHTML = text;
    });