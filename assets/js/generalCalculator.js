import React from 'react';

let operandNumber=0;
const calcBtnClick = (e) => {
  // e.preventDefault();
  // const val = e.target.value;
  // let prevStr = document.getElementById('screen').innerHTML;
  // operandNumber++;
  // document.getElementById('screen').innerHTML += val;
  // console.log(prevStr);
  // if(val in ['*','/','+','-'] && prevStr.charAt(prevStr.length-1) in ['*','/','+','-']) {
  //   console.log('2 operand ikathe');
  //   return;
  // }
};
const getResult = () => {
  const questionString =  document.getElementById('screen').innerHTML;
  document.getElementById('answer').innerHTML = 'Ans=';
}
const RenderCalulatorButton = () => {
  const btnVal = [1,2,3,'+',4,5,6,'-',7,8,9,'/','.',0,'*'];
  return btnVal.map((value, index) => {
    if(value == 4 || value == 7 || value == '.')
    {
    return([<br/>,<button className="btnval" value={value} key={index+""+value} onClick={calcBtnClick}>{value}</button>]);
    }
    return(<button className="btnval" value={value} key={index+""+value} onClick={calcBtnClick}>{value}</button>);
  });
};
export const GeneralCalculator = () => {
  return (
  <div className="outerBoundry">
    <div className="screen" id="screen">
    </div>
    <div className="answerscreen" id="answer">
    </div>
    <div className="button">
      <RenderCalulatorButton/>
      <button className="btnval" value="=" onClick={getResult}>=</button>
    </div>
  </div>);
};
