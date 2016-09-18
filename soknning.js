function showResources(returnedData){
    // An XML DOM document is returned from AJAX
    var resultset=returnedData.childNodes[0];
    var output="<table>";
    // Iterate over all nodes in root node (i.e. resources)
    for (i = 0; i < resultset.childNodes.length; i++) {
        // Iterate over all child nodes of that node that are resource nodes
        if(resultset.childNodes.item(i).nodeName=="resource"){
            // Retrieve data from resource nodes
            var resource=resultset.childNodes.item(i);
            output+="<tr onclick='alert(\""+resource.attributes['id'].value+"\")'>";
            output+="<td>"+resource.attributes['company'].nodeValue+"</td>";
            output+="<td>"+resource.attributes['name'].nodeValue+"</td>";
            output+="<td>"+resource.attributes['location'].nodeValue+"</td>";
            output+="<td>"+resource.attributes['size'].nodeValue+"</td>";
            output+="<td>"+resource.attributes['cost'].nodeValue+"</td>";
            output+="</tr>";
        }
    }
    output+="</table>"
    var div=document.getElementById('OutputDiv');
    div.innerHTML=output;
}
// Searching efter a resource
function searchResources(){
    var resname=document.getElementById("resName").value;
    $.ajax({
        type: 'POST',
        url: 'booking/getresources_XML.php',
        data: { name: escape(document.getElementById("resName").value),

            type: 'a11gusli'    // Filter out bookings made from other applications application.
            // Most commonly user name of student
        },
        success:  showResources
    });
}