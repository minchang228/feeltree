import processing.serial.*;
import processing.net.*;
Serial myPort;

float yaw = 0.0;
float pitch = 0.0;
float roll = 0.0;

String yaw1;
String pitch1;
String roll1;

Client c;
String data;
String domain = "www.big-thinker.co";
void setup()
{
  size(600, 500, P3D);

  // if you have only ONE serial port active
  //myPort = new Serial(this, Serial.list()[0], 9600); // if you have only ONE serial port active

  // if you know the serial port name
  myPort = new Serial(this, "COM3", 9600);                    // Windows
  //myPort = new Serial(this, "/dev/ttyACM0", 9600);             // Linux
  //myPort = new Serial(this, "/dev/cu.usbmodem1217321", 9600);  // Mac

  textSize(16); // set text size
  textMode(SHAPE); // set text mode to shape
}

void draw()
{
  serialEvent();  // read and parse incoming serial message
  background(255); // set background to white
  lights();

  translate(width/2, height/2); // set position to centre

  pushMatrix(); // begin object

  float c1 = cos(radians(roll));
  float s1 = sin(radians(roll));
  float c2 = cos(radians(pitch));
  float s2 = sin(radians(pitch));
  float c3 = cos(radians(yaw));
  float s3 = sin(radians(yaw));
  applyMatrix( c2*c3, s1*s3+c1*c3*s2, c3*s1*s2-c1*s3, 0,
               -s2, c1*c2, c2*s1, 0,
               c2*s3, c1*s2*s3-c3*s1, c1*c3+s1*s2*s3, 0,
               0, 0, 0, 1);

  drawArduino();

  popMatrix(); // end of object

  // Print values to console
  print(roll);
  print("\t");
  print(pitch);
  print("\t");
  print(yaw);
  println();
}

void serialEvent()
{
  int newLine = 13; // new line character in ASCII
  String message;
  do {
    message = myPort.readStringUntil(newLine); // read from port until new line
    if (message != null) {
      String[] list = split(trim(message), " ");
      if (list.length >= 4 && list[0].equals("Orientation:")) {
        yaw = float(list[1]); // convert to float yaw
        pitch = float(list[2]); // convert to float pitch
        roll = float(list[3]); // convert to float roll
        
        /* yaw1=str(yaw);
    pitch1=str(pitch);
    roll1=str(roll);
    String addr = "/getdata.php?sensorid=1&yaw="+yaw1+"&pitch="+pitch1+"&roll="+roll1;
    c = new Client(this, domain, 80);
    c.write("GET "+addr+" HTTP/1.1\r\n"); // Can replace / with, eg., /reference/ or similar path
    c.write("Host: "+domain+"\r\n"); // Which server is asked
    c.write("\r\n");
    if(c.available()>0)
      c.readString();*/
      }
    }
    
    yaw1=str(yaw);
    pitch1=str(pitch);
    roll1=str(roll);
    String addr = "/getdata.php?sensorid=1&yaw="+yaw1+"&pitch="+pitch1+"&roll="+roll1;
    System.out.print(addr);
    c = new Client(this, domain, 80);
    c.write("GET "+addr+" HTTP/1.1\r\n"); // Can replace / with, eg., /reference/ or similar path
    c.write("Host: "+domain+"\r\n"); // Which server is asked
    c.write("\r\n");
    if(c.available()>0)
      c.readString();
  } while (message != null);
}

void drawArduino()
{
  /* function contains shape(s) that are rotated with the IMU */
  stroke(0); // set outline colour to darker teal
  fill(0); // set fill colour to lighter teal
  box(300, 50, 50); // draw Arduino board base shape

  stroke(0,90,90); // set outline colour to black
  fill(0,90,90); // set fill colour to dark grey

  translate(-190, 0, 0); // set position to edge of Arduino box
  box(180, 180, 180); // draw pin header as box

  translate(0, 0, 0); // set position to other edge of Arduino box
  box(0); // draw other pin header as box
}