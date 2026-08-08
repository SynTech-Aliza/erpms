function populate(s1,s2)
                        {
                          var s1 = document.getElementById(s1);
                          var s2 = document.getElementById(s2);

                          if(s1.value == "Estancia"){
                            var routename = document.getElementById('route')
                            routename.value = "ONE (1)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Green";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Black";
                          }
                          else if(s1.value == "Linabuan Norte"){
                            var routename = document.getElementById('route')
                            routename.value = "ONE (1)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Green";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Orange";
                          }
                          else if(s1.value == "Mobo"){
                            var routename = document.getElementById('route')
                            routename.value = "ONE (1)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Green";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Crystal Green";
                          }
                          else if(s1.value == "Tigayon"){
                            var routename = document.getElementById('route')
                            routename.value = "ONE (1)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Green";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Red";
                          }
                          else if(s1.value == "Tinigao"){
                            var routename = document.getElementById('route')
                            routename.value = "ONE (1)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Green";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Silver";
                          }
                          else if(s1.value == "Bachao Norte"){
                            var routename = document.getElementById('route')
                            routename.value = "TWO (2)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Blue";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Gray";
                          }
                          else if(s1.value == "Bachao Sur"){
                            var routename = document.getElementById('route')
                            routename.value = "TWO (2)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Blue";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Pink";
                          }
                          else if(s1.value == "Buswang New"){
                            var routename = document.getElementById('route')
                            routename.value = "TWO (2)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Blue";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Violet";
                          }
                          else if(s1.value == "Buswang Old"){
                            var routename = document.getElementById('route')
                            routename.value = "TWO (2)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Blue";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Sky Blue";
                          }
                          else if(s1.value == "Andagao"){
                            var routename = document.getElementById('route')
                            routename.value = "THREE (3)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Orange";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Dark Blue";
                          }
                          else if(s1.value == "Briones"){
                            var routename = document.getElementById('route')
                            routename.value = "THREE (3)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Orange";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Apple Green";
                          }
                          else if(s1.value == "Caano"){
                            var routename = document.getElementById('route')
                            routename.value = "THREE (3)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Orange";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Dirty White";
                          }
                          else if(s1.value == "Mabilo"){
                            var routename = document.getElementById('route')
                            routename.value = "THREE (3)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Orange";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Light Green";
                          }
                          else if(s1.value == "Nalook"){
                            var routename = document.getElementById('route')
                            routename.value = "THREE (3)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Orange";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Yellow";
                          }
                          else if(s1.value == "Pook"){
                            var routename = document.getElementById('route')
                            routename.value = "THREE (3)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Orange";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "Caterpillar Yellow";
                          }
                          else if(s1.value == "Poblacion"){
                            var routename = document.getElementById('route')
                            routename.value = "FOUR (4)";
                            var bodycolorname = document.getElementById('bodycolor')
                            bodycolorname.value = "Violet & White";
                            var panelboardcolorname = document.getElementById('panelboardcolor')
                            panelboardcolorname.value = "White";
                          }
                          
                          for(var option in optionArray)
                          {
                            var pair = optionArray[option].split("|");
                            var newoption = document.createElement("option");
                            newoption.value = pair[0];
                            newoption.innerHTML=pair[1];
                            s2.options.add(newoption);
                          }
                        }