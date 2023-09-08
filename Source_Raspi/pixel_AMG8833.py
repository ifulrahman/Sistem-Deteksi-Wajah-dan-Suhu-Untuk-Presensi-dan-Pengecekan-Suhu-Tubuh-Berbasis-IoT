from Adafruit_AMG88xx import Adafruit_AMG88xx
from time import sleep

#import Adafruit_AMG88xx.Adafruit_AMG88xx as AMG88

# Default constructor will pick a default I2C bus.
#
# For the Raspberry Pi this means you should hook up to the only exposed I2C bus
# from the main GPIO header and the library will figure out the bus number based
# on the Pi's revision.
#
# For the Beaglebone Black the library will assume bus 1 by default, which is
# exposed with SCL = P9_19 and SDA = P9_20.
sensor = Adafruit_AMG88xx()

# Optionally you can override the bus number:
#sensor = AMG88.Adafruit_AMG88xx(busnum=2)

#wait for it to boot
sleep(.1)
dataSensor = []

while(1):
    dataSensor = sensor.readPixels()
    print(dataSensor)
    print(dataSensor[0])
    print(dataSensor[63])
    sleep(1)
    
	
