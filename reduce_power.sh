#!/bin/sh
modprobe bbswitch
sudo echo 'OFF' > /proc/acpi/bbswitch
echo '1500' > '/proc/sys/vm/dirty_writeback_centisecs';
echo 'min_power' > '/sys/class/scsi_host/host3/link_power_management_policy';
echo 'min_power' > '/sys/class/scsi_host/host2/link_power_management_policy';
echo '0' > '/proc/sys/kernel/nmi_watchdog';
echo 'min_power' > '/sys/class/scsi_host/host1/link_power_management_policy';
echo 'min_power' > '/sys/class/scsi_host/host4/link_power_management_policy';
echo 'auto' > '/sys/bus/i2c/devices/i2c-3/device/power/control';
echo 'auto' > '/sys/bus/i2c/devices/i2c-1/device/power/control';
echo 'auto' > '/sys/bus/i2c/devices/i2c-2/device/power/control';
echo 'auto' > '/sys/bus/i2c/devices/i2c-4/device/power/control';
echo 'auto' > '/sys/bus/usb/devices/1-10/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:00:14.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:00:1f.3/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:08:00.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:01:00.2/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:00:14.2/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:00:12.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:00:17.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:09:00.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:00:1f.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:06:00.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:00:00.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:00:1f.5/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:07:00.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:0a:00.0/power/control';
echo 'auto' > '/sys/bus/pci/devices/0000:00:04.0/power/control';
cat /proc/acpi/bbswitch;
sudo bash /home/macarthur/undervolt.sh
