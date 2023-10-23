## Microservice with UTA method POST endpoint 

## How to build
```
docker build -t uta_service .
```
## How to run
```
docker run -p 8000:8000 uta_service
```
### Example of POST endpoint body
```
{
  "performanceTable": [[3, 10, 1], [4, 20, 2], [2, 20, 0], [6, 40, 0], [30, 30, 3]],
  "criteriaMinMax": ["min", "min", "max"],
  "criteriaNumberOfBreakPoints": [3,4,4],
  "epsilon": 0.05,
  "rownamesPerformanceTable": ["RER","METRO1","METRO2","BUS","TAXI"],
  "colnamesPerformanceTable": ["Price","Time","Comfort"],
  "alternativesRanks": [1,2,2,3,4]
}
```
### Reponse format
```
{
    "optimum": [
        0
    ],
    "valueFunctions": {
        "Price": [
            [
                30,
                16,
                2
            ],
            [
                0,
                0,
                0.0875
            ]
        ],
        "Time": [
            [
                40,
                30,
                20,
                10
            ],
            [
                0,
                0,
                0.025,
                0.9
            ]
        ],
        "Comfort": [
            [
                0,
                1,
                2,
                3
            ],
            [
                0,
                0,
                0.0125,
                0.0125
            ]
        ]
    },
    "overallValues": [
        0.9812,
        0.1125,
        0.1125,
        0.0625,
        0.0125
    ],
    "ranks": [
        1,
        2,
        2,
        4,
        5
    ],
    "errors": [
        0,
        0,
        0,
        0,
        0
    ],
    "Kendall": [
        1
    ],
    "minimumWeightsPO": {},
    "maximumWeightsPO": {},
    "averageValueFunctionsPO": {}
}
```
### Used libraries

- [Plumber](https://www.rplumber.io/) - R package that enables to transform R code into a web API. With Plumber, R functions can be exposed as HTTP endpoints.
- [jsonlite](https://rdrr.io/cran/jsonlite/) - R package for working with JSON data. It provides functions to parse JSON data into R objects and serialize R objects into JSON format.
  
### Source code

https://github.com/paterijk/MCDA/blob/master/R/UTA.R

### Documentation

https://rdrr.io/cran/MCDA/man/UTA.html
