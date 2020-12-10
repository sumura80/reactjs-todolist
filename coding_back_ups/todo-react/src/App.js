import React ,{ Component }from 'react';


class App extends Component {
constructor(props){
  super(props);

  this.state={
    newItem:"",
    list:[]
  }
}

updateInput(key,value){
  this.setState({
    [key]:value
  })
}


addItem(){
  //アイテムとIdを作成
  const newItem ={
    id:1+Math.random(),
    value:this.state.newItem.slice()
  };
  
  //listアイテムをコピー
  const list = [...this.state.list]

  //listにアイテムを追加
  list.push(newItem);

  //inputボックスをからにする
  this.setState({
    list,
    newItem:""
  });
}

deleteItem(id){
  //listアイテムをコピー取得
  const list = [...this.state.list];
  //削除するアイテムをフィルターリングする
  const updatedList = list.filter(item => item.id !== id);
  this.setState({list:updatedList});
}


  render(){
    return (
      <div className="App">
        <h1 className="text-white text-center"><i class="fas fa-paste pr-2"></i>本日のタスク with <i class="fab fa-react"></i></h1>
        <form className="inputForm" onSubmit={this.handleSubmit}>
          <div className="input-group mt-4" >
            <input type="text" name="todoTask" className="form-control" placeholder="項目を入力してください" 
              value={this.state.newItem}
              onChange={e => this.updateInput('newItem', e.target.value)}
            />
            <div className="input-group-append">
              <button className="btn btn-warning" onClick={()=> this.addItem()} type="button">追加</button>
            </div>
          </div>
        </form>

        <br/>
        <ul className="list-group">
          {this.state.list.map(item=>{
            return(
              <li className="list-group-item my-2" key={item.id}>{item.value} <button onClick={()=>  this.deleteItem(item.id)} className="float-right btn btn-danger"><i class="far fa-trash-alt pr-2"></i>削除</button></li>
            )
          })}
        </ul>


      </div>// ./ className App 
    );
  }
}


export default App;
