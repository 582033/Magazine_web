function cut_str(str, len, hasDot) //截取字符串 包含中文处理{{{
//(串,长度,增加...) 
{ 
    var newLength = 0; 
    var newStr = ""; 
    var chineseRegex = /[^\x00-\xff]/g; 
    var singleChar = ""; 
    var strLength = str.replace(chineseRegex,"**").length; 
    for(var i = 0;i < strLength;i++) 
    { 
        singleChar = str.charAt(i).toString(); 
        if(singleChar.match(chineseRegex) != null) 
        { 
            newLength += 2; 
        }     
        else 
        { 
            newLength++; 
        } 
        if(newLength > len) 
        { 
            break; 
        } 
        newStr += singleChar; 
    } 
     
    if(hasDot && strLength > len) 
    { 
        newStr += "..."; 
    } 
    return newStr; 
} 
