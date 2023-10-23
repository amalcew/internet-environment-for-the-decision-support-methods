## Microservice with UTA method POST endpoint 

## Example of endpoint with parameters:

http://127.0.0.1:8000/UTA?
performanceTableJson=[[3, 10, 1], [4, 20, 2], [2, 20, 0], [6, 40, 0], [30, 30, 3]]&
criteriaMinMaxJson=["min", "min", "max"]&
criteriaNumberOfBreakPointsJson=[3,4,4]&
epsilon=0.05&rownamesPerformanceTableJson=["RER","METRO1","METRO2","BUS","TAXI"]&
colnamesPerformanceTableJson=["Price","Time","Comfort"]&
alternativesRanksJson=[1,2,2,3,4]