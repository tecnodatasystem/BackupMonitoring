<style>
/*@import "bourbon";

@import url(//fonts.googleapis.com/css?family=Oswald:400);*/
.chart {
  position: absolute;
  width: 450px;
  height: 450px;
  top: 320px;
  left: 50%;
  margin: -225px 0 0 -225px;
}
.doughnutTip {
  position: absolute;
  min-width: 30px;
  max-width: 300px;
  padding: 5px 15px;
  border-radius: 1px;
  background: rgba(0,0,0,.8);
  color: #ddd;
  font-size: 17px;
  text-shadow: 0 1px 0 #000;
  text-transform: uppercase;
  text-align: center;
  line-height: 1.3;
  letter-spacing: .06em;
  box-shadow: 0 1px 3px rgba(0,0,0,0.5);
  pointer-events: none;
  &::after {
      position: absolute;
      left: 50%;
      bottom: -6px;
      content: "";
      height: 0;
      margin: 0 0 0 -6px;
      border-right: 5px solid transparent;
      border-left: 5px solid transparent;
      border-top: 6px solid rgba(0,0,0,.7);
      line-height: 0;
  }
}
.doughnutSummary {
  position: absolute;
  top: 50%;
  left: 50%;
  color: #d5d5d5;
  text-align: center;
  text-shadow: 0 -1px 0 #111;
  cursor: default;
  color: black;
}
.doughnutSummaryTitle {
  position: absolute;
  top: 50%;
  width: 100%;
  margin-top: -27%;
  font-size: 22px;
  letter-spacing: .06em;
  color: black;
}
.doughnutSummaryNumber {
  position: absolute;
  top: 50%;
  width: 100%;
  margin-top: -15%;
  font-size: 55px;
  color: black;
}
.chart path:hover { opacity: 0.65; }
.legenda {
	padding: 10px; border-radius: 5px; color:white; border-top: 4px solid rgba(0, 0, 0, 0.498039); border-bottom: 4px solid rgba(0, 0, 0, 0.498039); 
}
.red {
	background-color: #FC4349;
}
.green {
	background-color: #57EF1E;
}
</style>