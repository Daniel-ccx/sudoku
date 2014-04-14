function $(id) {
	return document.getElementById(id);
}

//生成数独矩阵使用挖洞算法
var counter = 0;
var sudoku = {
	array_init: [],//程序初始的矩阵
	array_user: [],//玩家输入的结果矩阵
    array_digged: [],//随机挖掉的坐标记录
	complexity: 0.3,
    complexity_upper: 0.8,
	tableId: "boxGrid",
	
	rndBg: function() {
		var bg_num = Math.ceil(Math.random() + Math.random());

		$(this.tableId).className = "bg_" + bg_num;
	},

	init: function() {
		for(var i = 0; i < 9; i++)
		{
			this.array_init[i] = new Array();
            var tempArr = [1, 2, 3, 4, 5, 6, 7, 8, 9];
            for(var j=0; j < 9; j++)
            {
                //随机初始第一行
                if(i == 0)
                {
                    var rndIndex = Math.floor(Math.random() * (9 - j));

                    this.array_init[i][j] = tempArr[rndIndex];
                    tempArr.splice(rndIndex, 1);

                    continue;
                }
                this.array_init[i][j] = 0;
            }
		}
	},

	//递归
    fillInit: function(x, y) {
        x = arguments[0] || 1;
        y = arguments[1] || 0;
        if(x > 8 || y > 8)
            return true;

        for(var n = 1; n < 10; n++)
        {
            if(!this.chkRow(x, n))
                continue;

            if(!this.chkCol(x, y, n))
                continue;

            if(!this.chkUnit(x, y, n))
                continue;

            if(x > 2 && y > 2 && x == y)
            {
                var leftNums = this.getXLeftNumbers(this.array_init);
                if(leftNums.indexOf(n) > -1)
                    continue;
            }

            if(x > 2 && ((x + y) == 8))
            {
                var rightNums = this.getXRightNumbers(this.array_init);
                if(rightNums.indexOf(n) > -1)
                    continue;
            }

            this.array_init[x][y] = n;
            //console.log('(', x, y, ')', n, setted);
            if(y < 8) //先设置列
            {
                if(this.fillInit(x, y + 1))
                    return true;
            }
            else
            {
                //再设置行
                if(x < 8)
                {
                    tmp = y;
                    y = 0;
                    if(this.fillInit(x + 1, y))
                        return true;
                    y = tmp;
                }
                else
                    return true;
            }
            this.array_init[x][y] = 0;
            //console.log('un:(', x, y, ')', n, setted);
        }

		return false;
	},
    //行重复检测
    chkRow: function(x, num) {
        if((this.array_init[x] && this.array_init[x].indexOf(num) > -1 ))
        {
            return false;
        }
        return true;
    },
    //列重复
    chkCol: function(x, y, num) {
        for(var i = 0; i < x; i++)
        {
            if(this.array_init[i][y] == num)
            {
                return false;
            }
        }
        return true;
    },

    //对角线检测
    getXLeftNumbers: function(arr) {
        var tmp = [];
        for(var i = 0; i < 9; i++)
        {
            tmp.push(arr[i][i]);
        }
        return tmp;
    },
    getXRightNumbers: function(arr) {
        var tmp = [];
        for(var i = 0; i < 9; i++)
        {
            for(var j = 0; j < 9; j++)
            {
                if((i + j) == 8)
                {
                    tmp.push(arr[i][j]);
                }
            }
        }
        return tmp;
    },
    //九宫格检测
    chkUnit: function(x, y, num) {
        var unit = this.getUnitNumbers(x, y);
        if(unit.indexOf(num) > -1)
        {
            return false;
        }
        return true;
    },

	//获取九宫格域
	getDistrict: function(n) {
		return parseInt(n/3) * 3;
	},
    //获取九宫格内的数字
	getUnitNumbers: function(x, y) {
		var d_x = this.getDistrict(x);
		var d_y = this.getDistrict(y);
		var temp = [];
		for(var i = 0; i < x; i++)
		{
			var d_i = this.getDistrict(i);

			for(var j = 0; j < (d_y+3); j++)
			{
				//j所在区域
				var d_j = this.getDistrict(j);
				if(d_i == d_x && d_j == d_y)
				{
					temp.push(this.array_init[i][j]);
				}
			}
		}
		return temp;
	},	
	fillTable: function() {
		//填充行
		var trEle = "";
		for(var i = 0; i < 9; i++)
		{
			trEle += "<tr ";
			//横向
			if(i < 8 && (i+1)%3 == 0)
				trEle += "class='boldBottom'";
			trEle += ">";
			for(var j = 0; j < 9; j++)
			{
				trEle += "<td ";
                cls = "class='";

                if(i == j || (i+j == 8))
                    cls += 'x ';

				//纵向
				if(j < 8 && (j+1)%3 == 0 )
					cls += "boldRight ";
                trEle += cls + "'";

                var iptStyle = " style='";
                if(i == 0 && j == 0)
                    iptStyle += 'border-top-left-radius: 8px;';
                else if(i == 0 && j == 8)
                    iptStyle += 'border-top-right-radius: 8px;';
                else if(i == 8 && j == 0)
                    iptStyle += 'border-bottom-left-radius: 8px;';
                else if(i == 8 && j == 8)
                    iptStyle += 'border-bottom-right-radius: 8px;';

                if(i == 0)
                    iptStyle += 'border-top: 0px;';
                if(i == 8)
                    iptStyle += 'border-bottom: 0px;';

                if(j == 0)
                    iptStyle += 'border-left: 0px;';
                if(j == 8)
                    iptStyle += 'border-right: 0px;';
                iptStyle += "'";

				trEle += iptStyle + ">";

				var disable = '';
				var val = '';
                var complex = Math.random();
                if(complex > this.complexity && complex < this.complexity_upper)
                {
                    disable = 'disabled';
                    val = this.array_init[i][j];
                    this.array_digged.push(i + ',' + j);
                }
				trEle += "<input type='text' value='" + val + "' " + disable + " maxlength=1 id='g_" + i + j + "'/>";
				trEle += "</td>";
			}
			trEle += "</tr>";
			
		}
		$(this.tableId).innerHTML = trEle;
	},

	exec: function() {
		this.init();
		this.fillInit();
		this.fillTable();
		this.rndBg();
	},
    //检测用户输入
    chkUserArray: function(x, y) {
        var tmp_arr = this.array_user;
        var tmp = tmp_arr[x][y];
        tmp_arr[x][y] = 0;

        if(tmp_arr[x].indexOf(tmp) > -1)
            return false;
         
        for(var i = 0; i < 9; i++)
        {
            if(tmp_arr[i][y] == tmp)
            {
                return false;
            }
        }

		var d_x = this.getDistrict(x);
		var d_y = this.getDistrict(y);
        for(var i = 0; i < 3; i++)
        {
            for(var j = 0; j < 3; j++)
            {
                if(tmp_arr[d_x+i][d_y+j] == tmp)
                    return false;
            }
        }

        //对角线
        if(x == y)
        {
            var leftNums = this.getXLeftNumbers(tmp_arr);
            if(leftNums.indexOf(tmp) > -1)
                return false;
        }

        if((x + y) == 8)
        {
            var rightNums = this.getXRightNumbers(tmp_arr);
            if(rightNums.indexOf(tmp) > -1)
                return false;
        }

        return true;
    },
	chkResult: function() {
		//获取客户端的整个矩阵
		for(var i = 0; i < 9; i++)
		{
            this.array_user[i] = [];
			for(var j = 0; j < 9; j++)
			{
				var val = parseInt($('g_' + i + j).value);
				if(!val)
				{
					alert("您尚未完成此题目，请完成后再检查结果");
					return;
				}
				this.array_user[i][j] = val;
			}
		}

        //检测客户端的矩阵数字是否合法
        for(var i = 0; i < this.array_digged.length; i++)
        {
            var loc = this.array_digged[i].split(',');
            if(!this.chkUserArray(loc[0], loc[1]))
            {
                alert('输入有误，请重新检查');
                return;
            }
        }
        alert("congratulations");
        return;
	}
}
sudoku.exec();
